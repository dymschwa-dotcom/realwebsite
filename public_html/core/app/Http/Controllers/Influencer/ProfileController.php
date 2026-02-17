<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Platform;
use App\Models\ProfileGallery;
use App\Models\SocialLink;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {

    protected $activeTemplate;

    public function __construct() {
        $this->activeTemplate = activeTemplate();
    }

    /**
     * Show the profile setting page.
     */
    public function profile() {
        $pageTitle  = "Update Profile Details";
        $influencer = authInfluencer();
        
        $influencer->load('socialLinks', 'categories', 'galleries');

        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $categories = Category::active()->orderBy('name')->get();
        $platforms  = Platform::active()->get();

        return view($this->activeTemplate . 'influencer.profile_setting', compact(
            'pageTitle', 
            'influencer', 
            'countries', 
            'categories', 
            'platforms'
        ));
    }

    /**
     * Update the influencer profile.
     */
    public function submitProfile(Request $request) {
        $request->validate([
            'firstname'   => 'required|string|max:40',
            'lastname'    => 'required|string|max:40',
            'city'        => 'nullable|string|max:40',
            'bio'         => 'nullable|string|max:1000', // Added Bio validation
            'gender'      => 'nullable|in:male,female,other',
            'image'       => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'category'    => 'nullable|array',
            'social_link' => 'nullable|array',
            'followers'   => 'nullable|array',
            'gallery'     => 'nullable|array', // Added Gallery array validation
            'gallery.*'   => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        $influencer = authInfluencer();

        // 1. Handle Profile Image Upload
        if ($request->hasFile('image')) {
            try {
                $old = $influencer->image;
                $influencer->image = fileUploader($request->image, getFilePath('influencer'), getFileSize('influencer'), $old, getFileThumb('influencer'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your profile image'];
                return back()->withNotify($notify);
            }
        }

        // 2. Map Basic Info & BIO
        $influencer->firstname = $request->firstname;
        $influencer->lastname  = $request->lastname;
        $influencer->bio       = $request->bio; // FIXED: Saving bio to database
        $influencer->gender    = $request->gender;
        $influencer->city      = $request->city;
        
        if ($request->country) {
            $influencer->country_name = $request->country;
        }

        $influencer->save();

        // 3. Sync Categories
        $influencer->categories()->sync($request->category);

        // 4. Handle Multi-Image Gallery Upload
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                try {
                    $newImage = fileUploader($file, getFilePath('profileGallery'), getFileSize('profileGallery'), null, getFileThumb('profileGallery'));
                    
                    $gallery                = new ProfileGallery();
                    $gallery->influencer_id = $influencer->id;
                    $gallery->image         = $newImage;
                    $gallery->save();
                } catch (\Exception $exp) {
                    // Continue even if one image fails
                }
            }
        }

        // 5. Fixed Social Links Logic
        if ($request->social_link) {
            foreach ($request->social_link as $platformId => $urlValue) {
                if (!empty($urlValue)) {
                    SocialLink::updateOrCreate(
                        [
                            'influencer_id' => $influencer->id, 
                            'platform_id'   => $platformId
                        ],
                        [
                            'social_link' => $urlValue,
                            'followers'   => isset($request->followers[$platformId]) ? (int)$request->followers[$platformId] : 0
                        ]
                    );
                } else {
                    SocialLink::where('influencer_id', $influencer->id)->where('platform_id', $platformId)->delete();
                }
            }
        }
        
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    /**
     * Change Password Logic
     */
    public function changePassword() {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'influencer.password', compact('pageTitle'));
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

        $influencer = authInfluencer();
        if (Hash::check($request->current_password, $influencer->password)) {
            $influencer->password = Hash::make($request->password);
            $influencer->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Current password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    /**
     * Dedicated method for removing gallery images (used by AJAX or Delete links)
     */
    public function removeGalleryImage($id) {
        $gallery = ProfileGallery::where('influencer_id', authInfluencerId())->findOrFail($id);
        fileManager()->removeFile(getFilePath('profileGallery') . '/' . $gallery->image);
        $gallery->delete();
        $notify[] = ['success', 'Image removed successfully'];
        return back()->withNotify($notify);
    }
}