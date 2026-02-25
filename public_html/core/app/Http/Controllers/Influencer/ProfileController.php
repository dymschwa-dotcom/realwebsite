<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
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
        $galleries    = $influencer->galleries()->orderBy('sort_order', 'asc')->get();
        $languageData = json_decode(file_get_contents(resource_path('views/partials/languages.json')));
        $platforms    = \App\Models\Platform::active()->get();
        $regions      = json_decode(file_get_contents(resource_path('views/partials/regions.json')), true);
        return view('Template::influencer.profile_setting', compact('pageTitle', 'influencer', 'categories', 'galleries', 'languageData', 'platforms', 'regions'));
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'firstname'    => 'required|string',
            'lastname'     => 'required|string',
            'address'      => 'required|string|max:255',
            'tax_number'   => ['required', 'string', 'max:12', 'regex:/^[0-9]{2,3}-?[0-9]{3}-?[0-9]{3}$/'],
            'is_gst_registered' => 'nullable|boolean',
            'gst_number'   => ['required_if:is_gst_registered,1', 'nullable', 'string', 'max:12', 'regex:/^[0-9]{2,3}-?[0-9]{3}-?[0-9]{3}$/'],
            'category'     => 'required|array|min:1',
            'category.*'   => 'integer|exists:categories,id',
            'bio'          => 'nullable|string',
            'gender'       => 'nullable|string|in:male,female,other',
            'birth_date'   => 'nullable|date_format:Y-m-d|before:tomorrow',
            'image'        => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png']), 'max:5120'],
            'social_link'  => 'nullable|array',
            'followers'    => 'nullable|array',
            'package'      => 'nullable|array',
            'package.*.id' => 'nullable|integer',
            'package.*.name' => 'nullable|string|max:255',
            'package.*.description' => 'nullable|string',
            'package.*.price' => 'nullable|numeric|min:0',
            'package.*.platform_id' => 'nullable|integer|exists:platforms,id',
            'package.*.delivery_time' => 'nullable|integer|min:1',
            'package.*.post_count' => 'nullable|integer|min:1',
            'package.*.video_length' => 'nullable|integer|min:0',
            'images'       => 'nullable|array',
            'images.*'     => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'region'       => 'nullable|string',
            'video_url'    => 'nullable|string|max:255', // Lenient string validation
        ], [
            'firstname.required'  => 'The first name field is required',
            'lastname.required'   => 'The last name field is required',
            'address.required'    => 'The address field is required for KYC compliance',
            'tax_number.required' => 'The IRD/TFN tax number is required for payments',
            'image.max'           => 'Profile image may not be greater than 5MB',
        ]);

        $influencer = authInfluencer();

        // Handle Profile Image
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
        $influencer->address    = $request->address;
        $influencer->tax_number = str_replace('-', '', $request->tax_number);
        $influencer->is_gst_registered = $request->is_gst_registered ? 1 : 0;
        $influencer->gst_number = $request->gst_number ? str_replace('-', '', $request->gst_number) : null;
        $influencer->gender     = $request->gender;
        $influencer->birth_date = $request->birth_date;
        $influencer->city       = $request->city;
        $influencer->bio        = $request->bio;
        $influencer->region     = $request->region;

        if ($request->category) {
            $influencer->categories()->sync($request->category);
        }

        // Automated KYC Status Sync
        if ($request->tax_number && $request->address && $influencer->stripe_onboarded) {
            $influencer->kv = \App\Constants\Status::KYC_VERIFIED;
        } else {
            $influencer->kv = \App\Constants\Status::KYC_UNVERIFIED;
        }

        $influencer->save();

        // Handle Social Links
        if ($request->social_link) {
            foreach ($request->social_link as $platformId => $link) {
                if (!empty($link)) {
                    \App\Models\SocialLink::updateOrCreate(
                        ['influencer_id' => $influencer->id, 'platform_id' => $platformId],
                        ['social_link' => $link, 'followers' => $request->followers[$platformId] ?? 0]
                    );
                } else {
                    \App\Models\SocialLink::where('influencer_id', $influencer->id)->where('platform_id', $platformId)->delete();
                }
            }
        }

        // Handle Packages
        $keepPackageIds = [];
        if ($request->package && is_array($request->package)) {
            foreach ($request->package as $item) {
                if (empty($item['name'])) continue;
                if (!empty($item['id'])) {
                    $package = \App\Models\InfluencerPackage::where('influencer_id', $influencer->id)->find($item['id']);
                } else {
                    $package = new \App\Models\InfluencerPackage();
                    $package->influencer_id = $influencer->id;
                }

                if ($package) {
                    $package->name = $item['name'];
                    $package->description = $item['description'] ?? '';
                    $package->price = $item['price'] ?? 0;
                    $package->platform_id = $item['platform_id'] ?? null;
                    $package->delivery_time = $item['delivery_time'] ?? 7;
                    $package->post_count = $item['post_count'] ?? 1;
                    $package->video_length = $item['video_length'] ?? 0;
                    $package->save();
                    $keepPackageIds[] = $package->id;
                }
            }
        }
        \App\Models\InfluencerPackage::where('influencer_id', $influencer->id)->whereNotIn('id', $keepPackageIds)->delete();

        // Handle Gallery Images
        if ($request->hasFile('images')) {
            $lastSortOrder = \App\Models\ProfileGallery::where('influencer_id', $influencer->id)->max('sort_order') ?? 0;
            foreach ($request->file('images') as $image) {
                try {
                    $newImage = fileUploader($image, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                    $gallery                = new \App\Models\ProfileGallery();
                    $gallery->influencer_id = $influencer->id;
                    $gallery->image         = $newImage;
                    $gallery->sort_order    = ++$lastSortOrder;
                    $gallery->save();
                } catch (\Exception $exp) { }
            }
        }
        if ($request->cropped_images) {
    foreach ($request->cropped_images as $base64Data) {
        // Convert Base64 to a temporary file for your fileUploader
        $image_data = explode(',', $base64Data);
        $image_file = base64_decode($image_data[1]);
        $filename = uniqid() . '.jpg';
        $path = getFilePath('profileGallery');
        
        // Save file
        file_put_contents($path . '/' . $filename, $image_file);
        
        // Save to Database
        $gallery = new Gallery();
        $gallery->influencer_id = $influencer->id;
        $gallery->image = $filename;
        $gallery->save();
    }
}
        // Handle Video URL
        if ($request->video_url) {
            $lastSortOrder = \App\Models\ProfileGallery::where('influencer_id', $influencer->id)->max('sort_order') ?? 0;
            $gallery = new \App\Models\ProfileGallery();
            $gallery->influencer_id = $influencer->id;
            $gallery->video_url = $request->video_url;
            $gallery->sort_order = ++$lastSortOrder;
            $path = getFilePath('profileGallery');

            if (strpos($request->video_url, 'youtube.com') !== false || strpos($request->video_url, 'youtu.be') !== false) {
                $gallery->video_type = 'youtube';
                $thumbUrl = $this->getYoutubeThumbnail($request->video_url);
                if ($thumbUrl && $thumbUrl != 'default_video.jpg') {
                    try {
                        $contents = file_get_contents($thumbUrl);
                        $filename = 'yt_' . uniqid() . '.jpg';
                        if (!file_exists($path)) { mkdir($path, 0755, true); }
                        file_put_contents($path . '/' . $filename, $contents);
                        $gallery->image = $filename;
                    } catch (\Exception $e) { $gallery->image = 'default_video.jpg'; }
                } else { $gallery->image = 'default_video.jpg'; }
            } else {
                $gallery->video_type = 'link';
                $gallery->image = 'default_video.jpg';
            }
            $gallery->save();
        }

        recentActivity('Profile updated successfully', 0, $influencer->id);
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
            $influencer->password = Hash::make($request->password);
            $influencer->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The current password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function remove($id) {
        $gallery = ProfileGallery::where('influencer_id', authInfluencerId())->findOrFail($id);
        if ($gallery->image && !$gallery->video_url) {
            $path = getFilePath('profileGallery') . '/' . $gallery->image;
            @unlink($path);
        }
        $gallery->delete();

        $galleries = ProfileGallery::where('influencer_id', authInfluencerId())->orderBy('sort_order', 'asc')->get();
        foreach($galleries as $key => $item) {
            $item->sort_order = $key + 1;
            $item->save();
        }
        $notify[] = ['success', 'Item removed successfully'];
        return back()->withNotify($notify);
    }

    public function updateGalleryOrder(Request $request) {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:profile_galleries,id'
        ]);
        foreach ($request->order as $index => $id) {
            \App\Models\ProfileGallery::where('influencer_id', authInfluencerId())
                ->where('id', $id)
                ->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    protected function getYoutubeThumbnail($url) {
        $videoId = '';
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        } elseif (preg_match('/youtube\.com.*v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'default_video.jpg';
    }

    public function galleryStore(Request $request) {
        $request->validate([
            'gallery_image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png']), 'max:10240'],
        ], [
            'gallery_image.max' => 'Gallery images may not be greater than 10MB',
        ]);
        // Handle standalone upload if needed, otherwise logic is in submitProfile
    }
}