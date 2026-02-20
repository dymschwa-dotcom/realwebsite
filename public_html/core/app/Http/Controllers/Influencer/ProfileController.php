<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Lib\SocialConnect;
use App\Models\Category;
use App\Models\ProfileGallery;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {
    public function profile() {
        $pageTitle    = "Profile Setting";
        $influencer   = auth()->guard('influencer')->user();
        $categories   = Category::active()->select('id', 'name')->get();
        $galleries    = $influencer->galleries;
        $languageData = json_decode(file_get_contents(resource_path('views/partials/languages.json')));
        $platforms    = \App\Models\Platform::active()->get();
        $regions      = json_decode(file_get_contents(resource_path('views/partials/regions.json')), true);
        return view('Template::influencer.profile_setting', compact('pageTitle', 'influencer', 'categories', 'galleries', 'languageData', 'platforms', 'regions'));
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'category'     => 'required|array|min:1',
            'category.*'   => 'integer|exists:categories,id',
            'bio'          => 'nullable|string|max:255',
            'gender'       => 'nullable|string|in:male,female,other',
            'birth_date'   => 'nullable|date_format:Y-m-d|before:tomorrow',
            'image'        => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'social_link'  => 'required|array',
            'followers'    => 'required|array',
            'package'      => 'required|array|min:1',
            'package.*.id' => 'nullable|integer',
            'package.*.name' => 'required|string|max:255',
            'package.*.description' => 'required|string',
            'package.*.price' => 'required|numeric|min:0',
            'package.*.platform_id' => 'nullable|integer|exists:platforms,id',
            'package.*.delivery_time' => 'nullable|integer|min:1',
            'package.*.post_count' => 'nullable|integer|min:1',
            'package.*.video_length' => 'nullable|integer|min:0',
            'images'       => 'nullable|array',
            'images.*'     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'region'       => 'nullable|string',
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required',
        ]);

        $influencer = authInfluencer();

        if ($request->hasFile('image')) {
            try {
                $old               = $influencer->image;
                $influencer->image = fileUploader($request->image, getFilePath('influencer'), getFileSize('influencer'), $old, getFileThumb('influencer'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $influencer->firstname  = $request->firstname;
        $influencer->lastname   = $request->lastname;
        $influencer->gender     = $request->gender;
        $influencer->birth_date = $request->birth_date;

        $influencer->address = $request->address;
        $influencer->city    = $request->city;
        $influencer->state   = $request->state;
        $influencer->zip     = $request->zip;
        $influencer->bio        = $request->bio;
        $influencer->region     = $request->region;

        if ($request->category) {
            $influencer->categories()->sync($request->category);
        }

        // Handle Social Links
        foreach ($request->social_link as $platformId => $link) {
            if ($link) {
                \App\Models\SocialLink::updateOrCreate(
                    ['influencer_id' => $influencer->id, 'platform_id' => $platformId],
                    ['social_link' => $link, 'followers' => $request->followers[$platformId] ?? 0]
                );
            } else {
                \App\Models\SocialLink::where('influencer_id', $influencer->id)->where('platform_id', $platformId)->delete();
            }
        }

        // Handle Packages
        $packageIds = [];
        foreach ($request->package as $item) {
            if (@$item['id']) {
                $package = \App\Models\InfluencerPackage::where('influencer_id', $influencer->id)->find($item['id']);
            } else {
                $package = new \App\Models\InfluencerPackage();
                $package->influencer_id = $influencer->id;
            }
            if ($package) {
                $package->name = $item['name'];
                $package->description = $item['description'];
                $package->price = $item['price'];
                $package->platform_id = $item['platform_id'];
                $package->delivery_time = $item['delivery_time'];
                $package->post_count = $item['post_count'];
                $package->video_length = $item['video_length'];
                $package->save();
                $packageIds[] = $package->id;
            }
        }
        \App\Models\InfluencerPackage::where('influencer_id', $influencer->id)->whereNotIn('id', $packageIds)->delete();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $newImage = fileUploader($image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                    $gallery                = new \App\Models\ProfileGallery();
                    $gallery->influencer_id = $influencer->id;
                    $gallery->image         = $newImage;
                    $gallery->save();
                } catch (\Exception $exp) {
                }
            }
        }

        recentActivity('Profile updated successfully', 0, $influencer->id);
        $influencer->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword() {
        $pageTitle = 'Change Password';
        return view('Template::influencer.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request) {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        $influencer = auth()->guard('influencer')->user();
        if (Hash::check($request->current_password, $influencer->password)) {
            $password             = Hash::make($request->password);
            $influencer->password = $password;
            $influencer->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
        return back()->withNotify($notify);
    }
    }

    public function uploadGalleryImage(Request $request) {
        $maxUpload = gs('max_image_upload');
        $request->validate([
            'images'   => "required|array|max:$maxUpload",
            'images.*' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $newImage = fileUploader($image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Couldn\'t upload your image.'];
                    return back()->withNotify($notify);
                }

                $gallery                = new ProfileGallery();
                $gallery->influencer_id = authInfluencerId();
                $gallery->image         = $newImage;
                $gallery->save();
        }
}

        $notify[] = ['success', 'Images uploaded successfully'];
        return back()->withNotify($notify);
    }

    public function remove($id) {
        $gallery = ProfileGallery::where('influencer_id', authInfluencerId())->findOrFail($id);
        $path    = getFilePath('profileGallery') . '/' . $gallery->image;
        unlink($path);
        $gallery->delete();
        $notify[] = ['success', 'Image removed successfully'];
        return back()->withNotify($notify);
    }

    public function submitSkill(Request $request) {

        $request->validate([
            "skills"   => "nullable|array",
            "skills.*" => "required|string",
        ], [
            'skills.*' => 'skill field is required',
        ]);

        $influencer         = authInfluencer();
        $influencer->skills = $request->skills;
        $influencer->save();

        recentActivity('Skill added successfully', 0, $influencer->id);
        $notify[] = ['success', 'Skill added successfully'];
        return back()->withNotify($notify);
    }

    public function addLanguage(Request $request) {

        $request->validate([
            'language'  => 'required|string|max:40',
            'listening' => 'required|in:Basic,Medium,Fluent',
            'speaking'  => 'required|in:Basic,Medium,Fluent',
            'writing'   => 'required|in:Basic,Medium,Fluent',
        ]);

        $influencer   = authInfluencer();
        $oldLanguages = authInfluencer()->languages ?? [];

        $addedLanguages = array_keys($oldLanguages);

        if (in_array(strtolower($request->language), array_map('strtolower', $addedLanguages))) {
            $notify[] = ['error', $request->language . ' already added'];
            return back()->withNotify($notify);
        }

        $newLanguage[$request->language] = [
            'listening' => $request->listening,
            'speaking'  => $request->speaking,
            'writing'   => $request->writing,
        ];

        $languages = array_merge($oldLanguages, $newLanguage);

        $influencer->languages = $languages;
        $influencer->save();

        recentActivity('Language added successfully', 0, $influencer->id);

        $notify[] = ['success', 'Language added successfully'];
        return back()->withNotify($notify);
    }

    public function removeLanguage($language) {
        $influencer     = authInfluencer();
        $oldLanguages   = $influencer->languages ?? [];
        $addedLanguages = array_keys($oldLanguages);

        if (in_array($language, $addedLanguages)) {
            unset($oldLanguages[$language]);
        }

        $influencer->languages = $oldLanguages;
        $influencer->save();

        recentActivity('Language removed successfully', 0, $influencer->id);

        $notify[] = ['success', 'Language removed successfully'];
        return back()->withNotify($notify);
    }

    public function socialConnect($provider) {
        $socialLogin = new SocialConnect($provider);
        return $socialLogin->redirectDriver();
    }

    public function callback($provider) {
        $socialLogin = new SocialConnect($provider);
        try {
            return $socialLogin->login();
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return to_route('home')->withNotify($notify);
        }
    }
}

