<?php

namespace App\Http\Controllers\Influencer\Auth;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Influencer;
use App\Models\User;
use App\Models\Category;
use App\Models\Platform;
use App\Models\SocialLink;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;

class RegisterController extends Controller {

    use RegistersUsers;

    public $activeTemplate;

    public function __construct() {
        parent::__construct();
        $this->activeTemplate = activeTemplate();
        
        // Exclude AJAX checks and profile completion from guest middleware
        $this->middleware('influencer.guest', ['except' => [
            'influencerData', 
            'influencerDataSubmit', 
            'checkUser', 
            'checkEmail', 
            'logout'
        ]]);
    }

    /**
     * AJAX Username Availability Check (Step 2)
     */
    public function checkUser(Request $request)
    {
        $exist['exists'] = Influencer::where('username', $request->username)->exists() || 
                           User::where('username', $request->username)->exists();
        
        return response()->json($exist);
    }

    /**
     * AJAX Email Availability Check (Step 1)
     */
    public function checkEmail(Request $request)
    {
        $exist['exists'] = Influencer::where('email', $request->email)->exists() || 
                           User::where('email', $request->email)->exists();
        
        return response()->json($exist);
    }

    public function redirectTo()
    {
        return route('influencer.data');
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Influencer Registration";
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @$info['code'];
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        
        return view($this->activeTemplate . 'influencer.auth.register', compact('pageTitle', 'mobileCode', 'countries'));
    }

    protected function validator(array $data)
    {
        $general = gs();
        $agree = $general->agree ? 'required' : 'nullable';
        return Validator::make($data, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|string|email|unique:influencers',
            'password'  => 'required|string|min:6|confirmed',
            'agree'     => $agree,
        ]);
    }

    protected function create(array $data)
    {
        $influencer = new Influencer();
        $influencer->firstname = $data['firstname'];
        $influencer->lastname  = $data['lastname'];
        $influencer->email     = strtolower($data['email']);
        $influencer->password  = Hash::make($data['password']);
        $influencer->status    = Status::USER_ACTIVE;
        $influencer->ev        = gs()->ev ? Status::NO : Status::YES;
        $influencer->sv        = gs()->sv ? Status::NO : Status::YES;
        $influencer->profile_complete = Status::NO; 
        $influencer->save();

        return $influencer;
    }

    protected function guard()
    {
        return auth()->guard('influencer');
    }

    public function influencerData()
    {
        $influencer = authInfluencer();
        if ($influencer->profile_complete == Status::YES) {
            return to_route('influencer.home');
        }
        
        $pageTitle = "Complete Your Profile";
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $categories = Category::active()->orderBy('name')->get();
        $platforms = Platform::active()->get();

        return view($this->activeTemplate . 'influencer.user_data', compact('pageTitle', 'influencer', 'countries', 'categories', 'platforms'));
    }

    public function influencerDataSubmit(Request $request)
    {
        $influencer = authInfluencer();
        if ($influencer->profile_complete == Status::YES) {
            return to_route('influencer.home');
        }

        $request->validate([
            'username'    => 'required|string|alpha_num|unique:influencers,username|min:6',
            'country'     => 'required|string',
            'city'        => 'required|string',
            'mobile'      => 'required|numeric',
            'gender'      => 'required|in:male,female,other',
            'birth_date'  => 'required|date_format:d-m-Y',
            'category'    => 'required|array|min:1',
            'image'       => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($request->hasFile('image')) {
            try {
                $influencer->image = fileUploader($request->image, getFilePath('influencer'), getFileSize('influencer'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $influencer->username     = $request->username;
        $influencer->country_code = $request->country_code;
        $influencer->mobile       = $request->mobile_code . $request->mobile;
        $influencer->gender       = $request->gender;
        $influencer->city         = $request->city;
        
        try {
            $influencer->birth_date = Carbon::createFromFormat('d-m-Y', $request->birth_date)->format('Y-m-d');
        } catch (\Exception $e) {
            $notify[] = ['error', 'Invalid birth date format.'];
            return back()->withInput()->withNotify($notify);
        }

        $influencer->profile_complete = Status::YES;
        $influencer->save();

        $influencer->categories()->sync($request->category);

        if ($request->social_link) {
            foreach ($request->social_link as $platformId => $url) {
                if (!empty($url)) {
                    SocialLink::updateOrCreate(
                        ['influencer_id' => $influencer->id, 'platform_id' => $platformId],
                        [
                            'social_link' => $url,
                            'followers'   => isset($request->followers[$platformId]) ? $request->followers[$platformId] : 0
                        ]
                    );
                }
            }
        }

        $adminNotification = new AdminNotification();
        $adminNotification->influencer_id = $influencer->id;
        $adminNotification->title = 'Influencer profile completed: '.$influencer->username;
        $adminNotification->click_url = urlPath('admin.users.detail', $influencer->id);
        $adminNotification->save();

        $notify[] = ['success', 'Registration completed successfully!'];
        return to_route('influencer.services.add')->withNotify($notify);
    }
}