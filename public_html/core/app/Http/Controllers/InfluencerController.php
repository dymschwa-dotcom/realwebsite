<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Influencer;
use App\Models\Page;
use App\Models\Participant;
use App\Models\Platform;
use App\Models\Review;
use Illuminate\Http\Request;

class InfluencerController extends Controller {

    public function all(Request $request) {
        $pageTitle         = 'All Influencer';
        $collectInfluencer = Influencer::active();

        $countries  = collect(json_decode($collectInfluencer->get(), true))->pluck('country_name')->unique();
        $cities     = collect(json_decode($collectInfluencer->whereNotNull('city')->get(), true))->pluck('city')->unique();
        $categories = Category::active()->orderBy('name')->get();
        $platforms  = Platform::active()->select('id', 'name')->orderBy('name')->get();

        $influencers = $this->filterInfluencer();

        $influencers = $influencers->searchable(['username', 'firstname', 'lastname'])->filter(['gender'])->withCount('jobCompleted')->orderBy('order_completed', 'desc')->with('socialLink.platform')->withSum('socialLink', 'followers')->paginate(getPaginate());

        $favoriteInfluencer = Favorite::where('user_id', auth()->id())->select('influencer_id')->pluck('influencer_id')->toArray();
        $sections           = Page::where('tempname', activeTemplate())->where('slug', 'influencers')->first();

        return view('Template::influencers', compact('influencers', 'pageTitle', 'countries', 'categories', 'platforms', 'cities', 'favoriteInfluencer', 'sections'));
    }

    public function profile($name) {
        $pageTitle  = 'Influencer Profile';
        $influencer = Influencer::where('username', $name)->active()->with(['socialLink' => function ($q) {
            $q->where('followers', '>', 0)->with('platform');
        }, 'galleries' => function ($query) {
            $query->latest()->take(6);
        }])->firstOrFail();
        $reviews            = Review::where('influencer_id', $influencer->id)->with('user')->orderBy('id', 'desc')->take(5)->get();
        $topRatedInfluencer = Influencer::active()->with('socialLink.platform')->withSum('socialLink', 'followers')->where('order_completed', '>', 0)->orderBy('order_completed', 'desc')->take(6)->get();
        $favoriteInfluencer = Favorite::where('user_id', auth()->id())->select('influencer_id')->pluck('influencer_id')->toArray();

        $completedCampaign = Participant::where('influencer_id', $influencer->id)->completed()->with(['campaign' => function ($q) {
            $q->with('categories', 'platforms')->withCount('participants');
        }])->orderBy('id', 'desc')->limit(8)->get();

        $seoContents                     = new \stdClass();
        $seoContents->keywords           = $influencer->skills ?? [];
        $seoContents->social_title       = $influencer->fullname;
        $seoContents->description        = strLimit($influencer->bio, 150);
        $seoContents->social_description = strLimit($influencer->bio, 150);
        $seoImage                        = getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer'));
        return view('Template::influencer_profile', compact('pageTitle', 'influencer', 'reviews', 'topRatedInfluencer', 'favoriteInfluencer', 'completedCampaign', 'seoContents', 'seoImage'));
    }

        protected function filterInfluencer() {
        $influencer = Influencer::active();
        $request    = request();

        // 1. PLATFORMS (Combinable)
        $platforms = array_filter(array_unique((array)$request->platform_name));
        if ($request->platform) $platforms[] = $request->platform;
        
        if (!empty($platforms)) {
            $platformIds = Platform::active()->whereIn('name', $platforms)->pluck('id')->toArray();
            $influencer->whereHas('socialLink', function ($q) use ($platformIds) {
                $q->whereIn('platform_id', $platformIds)->where('followers', '>', 0);
            });
        }

        // 2. CATEGORIES (Combinable)
        if ($request->category) {
            $categoryIds = Category::active()->whereIn('slug', (array)$request->category)->pluck('id')->toArray();
            $influencer->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('influencer_categories.category_id', $categoryIds);
            });
        }

        // 3. FOLLOWER RANGE (Combinable)
        if ($request->follower_range) {
            $ranges = (array)$request->follower_range;
            $influencer->whereHas('socialLink', function ($query) use ($ranges) {
                $query->where(function ($q) use ($ranges) {
                    foreach ($ranges as $range) {
                        if ($range == 1000000) {
                            $q->orWhere('followers', '>=', 1000000);
                        } else {
                            $parts = explode('_', $range);
                            if (count($parts) == 2) {
                                $q->orWhereBetween('followers', [$parts[0] * 1000, $parts[1] * 1000]);
                            }
                        }
                    }
                });
            });
        }

        // 4. GENDER (Combinable)
        if ($request->gender) {
            $influencer->whereIn('gender', (array)$request->gender);
        }

        // 5. LOCATION (Combinable)
        if ($request->country) $influencer->whereIn('country_name', (array)$request->country);
        if ($request->region) $influencer->whereIn('region', (array)$request->region);
        if ($request->city) $influencer->whereIn('city', (array)$request->city);

        // 6. PRICE
        if ($request->min_price || $request->max_price) {
            $influencer->whereHas('packages', function ($query) use ($request) {
                if ($request->min_price) $query->where('price', '>=', $request->min_price);
                if ($request->max_price) $query->where('price', '<=', $request->max_price);
            });
        }

        // 7. AGE (Combinable)
        if ($request->age_range) {
            $ranges = (array)$request->age_range;
            $influencer->where(function ($q) use ($ranges) {
                foreach ($ranges as $range) {
                    if ($range == '45_100') {
                        $q->orWhereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 45");
                    } else {
                        $parts = explode('_', $range);
                        if (count($parts) == 2) {
                            $q->orWhereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN ? AND ?", [$parts[0], $parts[1]]);
                        }
                    }
                }
            });
        }

        if ($request->rating) $influencer->where('rating', '>=', $request->rating);
        if ($request->skill) $influencer->whereJsonContains('skills', $request->skill);

        return $influencer;
    }
}