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
        if ($request->platform) {
            $influencer->whereHas('socialLink.platform', function ($query) use ($request) {
                $query->where('name', $request->platform);
            });
        }

        if ($request->category) {
            $categories = Category::active()->whereIn('slug', (array) $request->category)->select('id')->get();
            if ($categories->count()) {
                $categoryIds = $categories->pluck('id')->toArray();
                $influencer->whereHas('categories', function ($query) use ($categoryIds) {
                    $query->whereIn('influencer_categories.category_id', $categoryIds);
                });
            }
        }
        if ($request->country) {
            $countries = (array) $request->country;
            $influencer->whereIn('country_name', $countries);
        }
        if ($request->region) {
            $regions = (array) $request->region;
            $influencer->whereIn('region', $regions);
        }
        if ($request->city) {
            $cities = (array) $request->city;
            $influencer->whereIn('city', $cities);
        }
        if ($request->platform_name) {
            $filterPlatforms = Platform::active()->whereIn('name', (array) $request->platform_name)->select('id')->get();
            if ($filterPlatforms->count()) {
                $platformIds = $filterPlatforms->pluck('id')->toArray();
                $influencer->whereHas('socialLink', function ($query) use ($platformIds) {
                    $query->whereIn('platform_id', $platformIds)->where('followers', '>', 0);
                });
            }

        }
        if ($request->follower_range) {
            $ranges = (array) $request->follower_range;
            $influencer->whereHas('socialLink', function ($query) use ($ranges) {
                $query->where(function ($q) use ($ranges) {
                    foreach ($ranges as $range) {
                        if ($range == 1000000) {
                            $q->orWhere('followers', '>=', 1000000);
                        } else {
                            $parts = explode('_', $range);
                            if (count($parts) == 2) {
                                $start = $parts[0] * 1000;
                                $end   = $parts[1] * 1000;
                                $q->orWhereBetween('followers', [$start, $end]);
                            }
                        }
                    }
                });
            });
        }

        if ($request->min_price || $request->max_price) {
            $influencer->whereHas('packages', function ($query) use ($request) {
                if ($request->min_price) {
                    $query->where('price', '>=', $request->min_price);
                }
                if ($request->max_price) {
                    $query->where('price', '<=', $request->max_price);
                }
            });
        }

        if ($request->rating) {
            $influencer = $influencer->where('rating', '>=', $request->rating);
        }
        if ($request->age_range) {
            $ranges = (array) $request->age_range;
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
        if ($request->skill) {
            $influencer->whereJsonContains('skills', $request->skill);
        }
        return $influencer;
    }

    public function reviews(Request $request) {
        $lastId  = $request->last_id;
        $reviews = Review::where('influencer_id', $request->influencer_id)->where('id', '<', $lastId)->orderBy('id', 'desc')->with('user')->limit(5)->get();
        if (blank($reviews)) {
            return response()->json(['error' => 'No more reviews yet']);
        }
        $html   = view('Template::partials.reviews', compact('reviews'))->render();
        $lastId = $reviews->last()->id;
        return response()->json(['html' => $html, 'lastId' => $lastId]);
    }
}

