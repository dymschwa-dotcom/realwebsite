<?php

namespace App\Http\Controllers\Influencer\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\Influencer;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller {

    use RegistersUsers;

    public function __construct() {
        parent::__construct();
    }

    public function showRegistrationForm() {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = "Register";
        Intended::identifyRoute();
        return view('Template::influencer.auth.register', compact('pageTitle'));
    }

    protected function validator(array $data) {

        $passwordValidation = Password::min(6);

        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = 'nullable';
        if (gs('agree')) {
            $agree = 'required';
        }

        $validate = Validator::make($data, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|string|email|unique:influencers',
            'password'  => ['required', 'confirmed', $passwordValidation],
            'captcha'   => 'sometimes|required',
            'agree'     => $agree,
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required'  => 'The last name field is required',
        ]);

        return $validate;
    }

    public function register(Request $request) {
        if (!gs('influencer_registration')) {
            $notify[] = ['error', 'Registration not allowed'];
            return back()->withNotify($notify);
        }
        $this->validator($request->all())->validate();

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        event(new Registered($influencer = $this->create($request->all())));

        $this->guard()->login($influencer);

        return $this->registered($request, $influencer)
        ?: redirect($this->redirectPath());
    }

    protected function create(array $data) {
        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = Influencer::where('referral_code', $referBy)->first();
        } else {
            $referUser = null;
        }

        $influencer                = new Influencer();
        $influencer->email         = strtolower($data['email']);
        $influencer->firstname     = $data['firstname'];
        $influencer->lastname      = $data['lastname'];
        $influencer->password      = Hash::make($data['password']);
        $influencer->ref_by        = $referUser ? $referUser->id : 0;
        $influencer->referral_code = getTrx();
        $influencer->kv            = gs('kv') ? Status::NO : Status::YES;
        $influencer->ev            = gs('ev') ? Status::NO : Status::YES;
        $influencer->sv            = gs('sv') ? Status::NO : Status::YES;
        $influencer->ts            = Status::DISABLE;
        $influencer->tv            = Status::ENABLE;
        $influencer->save();

        $adminNotification                = new AdminNotification();
        $adminNotification->influencer_id = $influencer->id;
        $adminNotification->title         = 'New influencer registered';
        $adminNotification->click_url     = urlPath('admin.users.detail', $influencer->id);
        $adminNotification->save();

        //Login Log Create
        $ip              = getRealIP();
        $exist           = UserLogin::where('influencer_id', $ip)->first();
        $influencerLogin = new UserLogin();

        if ($exist) {
            $influencerLogin->longitude    = $exist->longitude;
            $influencerLogin->latitude     = $exist->latitude;
            $influencerLogin->city         = $exist->city;
            $influencerLogin->country_code = $exist->country_code;
            $influencerLogin->country      = $exist->country;
        } else {
            $info                          = json_decode(json_encode(getIpInfo()), true);
            $influencerLogin->longitude    = @implode(',', $info['long']);
            $influencerLogin->latitude     = @implode(',', $info['lat']);
            $influencerLogin->city         = @implode(',', $info['city']);
            $influencerLogin->country_code = @implode(',', $info['code']);
            $influencerLogin->country      = @implode(',', $info['country']);
        }

        $influencerAgent                = osBrowser();
        $influencerLogin->influencer_id = $influencer->id;
        $influencerLogin->user_ip       = $ip;

        $influencerLogin->browser = @$influencerAgent['browser'];
        $influencerLogin->os      = @$influencerAgent['os_platform'];
        $influencerLogin->save();

        return $influencer;
    }

    protected function guard() {
        return auth()->guard('influencer');
    }

    public function checkUser(Request $request) {
        $exist['data'] = false;
        $exist['type'] = null;
        if ($request->email) {
            $exist['data']  = Influencer::where('email', $request->email)->exists();
            $exist['type']  = 'email';
            $exist['field'] = 'Email';
        }
        if ($request->mobile) {
            $exist['data']  = Influencer::where('mobile', $request->mobile)->where('dial_code', $request->mobile_code)->exists();
            $exist['type']  = 'mobile';
            $exist['field'] = 'Mobile';
        }
        if ($request->username) {
            $exist['data']  = Influencer::where('username', $request->username)->exists();
            $exist['type']  = 'username';
            $exist['field'] = 'Username';
        }
        return response($exist);
    }

    public function registered() {
        return to_route('influencer.home');
    }

}
