<?php

namespace App\Http\Controllers\Influencer\Auth;

use App\Models\User;
use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\InfluencerPasswordReset;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {

        $email = session('fpass_email');
        $token = session()->has('token') ? session('token') : $token;
        if (InfluencerPasswordReset::where('token', $token)->where('email', $email)->count() != 1) {
            $notify[] = ['error', 'Invalid token'];
            return to_route('influencer.password.request')->withNotify($notify);
        }
        return view('Template::influencer.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email, 'pageTitle' => 'Reset Password']
        );
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules());
        $reset = InfluencerPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        if (!$reset) {
            $notify[] = ['error', 'Invalid verification code'];
            return to_route('user.login')->withNotify($notify);
        }

        $influencer = Influencer::where('email', $reset->email)->first();
        $influencer->password = Hash::make($request->password);
        $influencer->save();


        $influencerIpInfo = getIpInfo();
        $influencerBrowser = osBrowser();
        notify($influencer, 'PASS_RESET_DONE', [
            'operating_system' => @$influencerBrowser['os_platform'],
            'browser' => @$influencerBrowser['browser'],
            'ip' => @$influencerIpInfo['ip'],
            'time' => @$influencerIpInfo['time']
        ],['email']);


        $notify[] = ['success', 'Password changed successfully'];
        return to_route('influencer.login')->withNotify($notify);
    }


    protected function rules()
    {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required','confirmed',$passwordValidation],
        ];
    }

}
