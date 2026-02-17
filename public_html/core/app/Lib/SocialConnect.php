<?php

namespace App\Lib;

use App\Constants\Status;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

class SocialConnect {
    private $provider;

    public function __construct($provider) {
        $this->provider = $provider;
        $this->configuration();
    }

    public function redirectDriver() {
        if ($this->provider == 'facebook') {
            $provider    = 'facebook';
            $permissions = [
                'pages_manage_posts',
                'pages_read_engagement',
                'pages_show_list',
            ];
        } else if ($this->provider == 'instagram') {
            $provider    = 'facebook';
            $permissions = [
                'instagram_basic',
                'pages_show_list',
                'business_management',
            ];
        } else {
            $provider    = 'google';
            $permissions = [
                'https://www.googleapis.com/auth/youtube',
                'https://www.googleapis.com/auth/youtube.readonly',
            ];
        }
        return Socialite::driver($provider)->scopes($permissions)->redirect();
    }

    private function configuration() {
        if ($this->provider == 'youtube') {
            $provider      = 'google';
            $configuration = gs()->socialite_credentials->youtube;
        } else {
            $provider      = 'facebook';
            $configuration = gs()->socialite_credentials->$provider;
        }
        Config::set('services.' . $provider, [
            'client_id'     => $configuration->client_id,
            'client_secret' => $configuration->client_secret,
            'redirect'      => route("influencer.social.connect.callback", $this->provider),
        ]);
    }

    public function login() {
        $provider = $this->provider == 'youtube' ? 'google' : 'facebook';
        $user     = Socialite::driver($provider)->user();
        if ($this->provider == 'facebook') {
            $connect = $this->connectFacebook($user);
            if ($connect['error']) {
                $notify[] = ['error', $connect['message']];
                return to_route('influencer.profile.setting')->withNotify($notify);
            }
            $notification = 'Facebook channel connected successfully';
        } else if ($this->provider == 'instagram') {
            $connect = $this->connectInstagram($user);
            if ($connect['error']) {
                $notify[] = ['error', $connect['message']];
                return to_route('influencer.profile.setting')->withNotify($notify);
            }
            $notification = 'Instagram channel connected successfully';
        } else {
            $connect = $this->connectYoutube($user);
            if ($connect['error']) {
                $notify[] = ['error', $connect['message']];
                return to_route('influencer.profile.setting')->withNotify($notify);
            }
            $notification = 'Youtube channel connected successfully';
        }
        $notify[] = ['success', $notification];
        return to_route('influencer.profile.setting')->withNotify($notify);
    }

    private function connectFacebook($user) {
        $data     = CurlRequest::curlContent('https://graph.facebook.com/v18.0/me/accounts?fields=fan_count&access_token=' . $user->token);
        $response = json_decode($data);
        if (!$response || !isset($response->data)) {
            return ['error' => true, 'message' => 'Failed to fetch data from Facebook'];
        }
        if (count($response->data) > 1) {
            return ['error' => true, 'message' => 'You can connect maximum one instagram channel'];
        }
        $social = SocialLink::notConnect()->where('influencer_id', authInfluencerId())->where('platform_id', 1)->first();
        if (!$social) {
            return ['error' => true, 'message' => 'Facebook channel not found'];
        }
        $social->channel_connect = Status::ENABLE;
        $social->followers       = @$response->data[0]->fan_count ?? 0;
        $social->save();

        return ['error' => false];
    }

    private function connectInstagram($user) {
        $data     = CurlRequest::curlContent("https://graph.facebook.com/v18.0/me/accounts?access_token=$user->token&fields=instagram_business_account{followers_count}");
        $response = json_decode($data);
        if (count($response->data) > 1) {
            return ['error' => true, 'message' => 'You can connect maximum one instagram channel'];
        }
        $social = SocialLink::notConnect()->where('influencer_id', authInfluencerId())->where('platform_id', 2)->first();
        if (!$social) {
            return ['error' => true, 'message' => 'Instagram channel not found'];
        }

        $social->channel_connect = Status::ENABLE;
        $social->followers       = @$response->data[0]->instagram_business_account->followers_count ?? 0;
        $social->save();
        return ['error' => false];
    }

    private function connectYoutube($user) {
        $url  = 'https://youtube.googleapis.com/youtube/v3/channels?part=snippet%2CcontentDetails%2Cstatistics&mine=true&key=' . gs()->socialite_credentials->youtube->api_key;
        $data = CurlRequest::curlContent($url, [
            "Authorization: Bearer $user->token",
            'Accept: application/json',
        ]);
        $response = json_decode($data);

        if (!$response) {
            return ['error' => true, 'message' => 'Invalid API request'];
        }

        $alreadySubscribed = SocialLink::where('social_user_id', @$user->attributes->id)->exists();
        if ($alreadySubscribed) {
            return ['error' => true, 'message' => 'Already subscribed with this google account'];
        }

        $social = SocialLink::notConnect()->where('influencer_id', authInfluencerId())->where('platform_id', 3)->first();
        if (!$social) {
            return ['error' => true, 'message' => 'Youtube channel not found'];
        }

        $social->channel_connect = Status::ENABLE;
        $social->followers       = @$response->items[0]->statistics->subscriberCount ?? 0;
        $social->social_user_id  = @$user->attributes->id ?? 0;
        $social->save();

        return ['error' => false];
    }
}
