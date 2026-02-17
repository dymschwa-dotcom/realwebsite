<?php

namespace App\Http\Controllers\Influencer;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Constants\Status;
use App\Lib\Intended;

class AuthorizationController extends Controller
{
    protected function checkCodeValidity($influencer,$addMin = 2)
    {
        if (!$influencer->ver_code_send_at){
            return false;
        }
        if ($influencer->ver_code_send_at->addMinutes($addMin) < Carbon::now()) {
            return false;
        }
        return true;
    }

    public function authorizeForm()
    {
        $influencer = auth()->guard('influencer')->user();
        if (!$influencer->status) {
            $pageTitle = 'Banned';
            $type = 'ban';
        }elseif(!$influencer->ev) {
            $type = 'email';
            $pageTitle = 'Verify Email';
            $notifyTemplate = 'EVER_CODE';
        }elseif (!$influencer->sv) {
            $type = 'sms';
            $pageTitle = 'Verify Mobile Number';
            $notifyTemplate = 'SVER_CODE';
        }elseif (!$influencer->tv) {
            $pageTitle = '2FA Verification';
            $type = '2fa';
        }else{
            return to_route('influencer.home');
        }

        if (!$this->checkCodeValidity($influencer) && ($type != '2fa') && ($type != 'ban')) {
            $influencer->ver_code = verificationCode(6);
            $influencer->ver_code_send_at = Carbon::now();
            $influencer->save();
            notify($influencer, $notifyTemplate, [
                'code' => $influencer->ver_code
            ],[$type]);
        }

        return view('Template::influencer.auth.authorization.'.$type, compact('influencer', 'pageTitle'));

    }

    public function sendVerifyCode($type)
    {
        $influencer = auth()->guard('influencer')->user();

        if ($this->checkCodeValidity($influencer)) {
            $targetTime = $influencer->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $targetTime - time();
            throw ValidationException::withMessages(['resend' => 'Please try after ' . $delay . ' seconds']);
        }

        $influencer->ver_code = verificationCode(6);
        $influencer->ver_code_send_at = Carbon::now();
        $influencer->save();

        if ($type == 'email') {
            $type = 'email';
            $notifyTemplate = 'EVER_CODE';
        } else {
            $type = 'sms';
            $notifyTemplate = 'SVER_CODE';
        }

        notify($influencer, $notifyTemplate, [
            'code' => $influencer->ver_code
        ],[$type]);

        $notify[] = ['success', 'Verification code sent successfully'];
        return back()->withNotify($notify);
    }

    public function emailVerification(Request $request)
    {
        $request->validate([
            'code'=>'required'
        ]);

        $influencer = auth()->guard('influencer')->user();

        if ($influencer->ver_code == $request->code) {
            $influencer->ev = Status::VERIFIED;
            $influencer->ver_code = null;
            $influencer->ver_code_send_at = null;
            $influencer->save();

            $redirection = Intended::getRedirection();
            return $redirection ? $redirection : to_route('influencer.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code didn\'t match!']);
    }

    public function mobileVerification(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ]);


        $influencer = auth()->guard('influencer')->user();
        if ($influencer->ver_code == $request->code) {
            $influencer->sv = Status::VERIFIED;
            $influencer->ver_code = null;
            $influencer->ver_code_send_at = null;
            $influencer->save();
            $redirection = Intended::getRedirection();
            return $redirection ? $redirection : to_route('influencer.home');
        }
        throw ValidationException::withMessages(['code' => 'Verification code didn\'t match!']);
    }

    public function g2faVerification(Request $request)
    {
        $influencer = auth()->guard('influencer')->user();
        $request->validate([
            'code' => 'required',
        ]);
        $response = verifyG2fa($influencer,$request->code);
        if ($response) {
            $redirection = Intended::getRedirection();
            return $redirection ? $redirection : to_route('user.home');
        }else{
            $notify[] = ['error','Wrong verification code'];
            return back()->withNotify($notify);
        }
    }
}
