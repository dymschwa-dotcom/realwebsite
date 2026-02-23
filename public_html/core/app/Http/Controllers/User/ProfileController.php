<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view('Template::user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'brand_name' => 'required|string|max:40',
            'website'    => 'required|url|max:255',
            'image'      => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png']), 'max:5120'],
            'address'    => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:50',
            'is_gst_registered' => 'nullable|boolean',
            'gst_number' => 'nullable|string|max:50',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required',
            'image.max'          => 'Profile image may not be greater than 5MB',
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        $user->brand_name = $request->brand_name;
        $user->website = $request->website;
        $user->address = $request->address;
        $user->tax_number = $request->tax_number;
        $user->is_gst_registered = $request->is_gst_registered ? 1 : 0;
        $user->gst_number = $request->gst_number;

        if ($request->hasFile('image')) {
            try {
                $user->image = fileUploader($request->image, getFilePath('brand'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];

        if (session()->has('redirect_after_profile_completion')) {
            $redirectUrl = session()->pull('redirect_after_profile_completion');
            return redirect($redirectUrl)->withNotify($notify);
        }

        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view('Template::user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password' => ['required','confirmed',$passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }
}

