<?php

namespace App\Http\Controllers\Influencer\Auth;

use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Models\InfluencerPasswordReset;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $pageTitle = "Account Recovery";
        return view('Template::influencer.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate([
            'value'=>'required'
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $fieldType = $this->findFieldType();
        $influencer = Influencer::where($fieldType, $request->value)->first();

        if (!$influencer) {
            $notify[] = ['error', 'The account could not be found'];
            return back()->withNotify($notify);
        }

        InfluencerPasswordReset::where('email', $influencer->email)->delete();
        $code = verificationCode(6);
        $password = new InfluencerPasswordReset();
        $password->email = $influencer->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $influencerIpInfo = getIpInfo();
        $influencerBrowserInfo = osBrowser();
        notify($influencer, 'PASS_RESET_CODE', [
            'code' => $code,
            'operating_system' => @$influencerBrowserInfo['os_platform'],
            'browser' => @$influencerBrowserInfo['browser'],
            'ip' => @$influencerIpInfo['ip'],
            'time' => @$influencerIpInfo['time']
        ],['email']);

        $email = $influencer->email;
        session()->put('pass_res_mail',$email);
        $notify[] = ['success', 'Password reset email sent successfully'];
        return to_route('influencer.password.code.verify')->withNotify($notify);
    }

    public function findFieldType()
    {
        $input = request()->input('value');

        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $input]);
        return $fieldType;
    }

    public function codeVerify(Request $request){
        $pageTitle = 'Verify Email';
        $email = $request->session()->get('pass_res_mail');
        if (!$email) {
            $notify[] = ['error','Oops! session expired'];
            return to_route('influencer.password.request')->withNotify($notify);
        }
        return view('Template::influencer.auth.passwords.code_verify',compact('pageTitle','email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'email' => 'required'
        ]);
        $code =  str_replace(' ', '', $request->code);

        if (InfluencerPasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            $notify[] = ['error', 'Verification code doesn\'t match'];
            return to_route('influencer.password.request')->withNotify($notify);
        }
        $notify[] = ['success', 'You can change your password'];
        session()->flash('fpass_email', $request->email);
        return to_route('influencer.password.reset', $code)->withNotify($notify);
    }

}
