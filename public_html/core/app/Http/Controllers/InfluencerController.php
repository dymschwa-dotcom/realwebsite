<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Influencer;
use App\Models\Page;
use App\Models\Platform;
use App\Models\Review;
use Illuminate\Http\Request;

class InfluencerController extends Controller {

    /**
     * Optimized Explore/Search Page
     */
    public function all(Request $request) {
        $pageTitle = 'Explore Influencers';
        
        // UPDATED: Changed socialLink to socialLinks
        $influencerQuery = Influencer::active()
            ->with(['socialLinks.platform', 'categories'])
            ->withCount('jobCompleted');

        // Filtering Logic
        if ($request->category) {
            $categories = (array) $request->category;
            $influencerQuery->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
        }

        if ($request->country) {
            $countriesFilter = (array) $request->country;
            $influencerQuery->whereIn('country_name', $countriesFilter);
        }

        if ($request->city) {
            $citiesFilter = (array) $request->city;
            $influencerQuery->whereIn('city', $citiesFilter);
        }

        if ($request->platform_name) {
            $platformsFilter = (array) $request->platform_name;
            // UPDATED: Changed socialLink to socialLinks
            $influencerQuery->whereHas('socialLinks.platform', function ($q) use ($platformsFilter) {
                $q->whereIn('name', $platformsFilter);
            });
        }

        if ($request->rating) {
            $influencerQuery->where('rating', '>=', $request->rating);
        }

        $influencers = $influencerQuery->orderBy('id', 'desc')->paginate(getPaginate());

        // Sidebar Data
        $countries  = Influencer::active()->whereNotNull('country_name')->distinct()->pluck('country_name');
        $cities     = Influencer::active()->whereNotNull('city')->distinct()->pluck('city');
        $categories = Category::active()->orderBy('name')->get();
        $platforms  = Platform::active()->orderBy('name')->get();
        
        $favoriteInfluencer = auth()->check() ? Favorite::where('user_id', auth()->id())->pluck('influencer_id')->toArray() : [];
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'influencers')->first();

        return view(activeTemplate() . 'influencers', compact(
            'influencers', 
            'pageTitle', 
            'countries', 
            'cities', 
            'categories', 
            'platforms', 
            'favoriteInfluencer', 
            'sections'
        ));
    }

    /**
     * Optimized Profile Page
     */
    public function profile($name) {
        $pageTitle = 'Influencer Profile';
        
        // UPDATED: Changed socialLink to socialLinks
        $influencer = Influencer::where('username', $name)
            ->active()
            ->with(['socialLinks.platform', 'galleries' => function ($query) {
                $query->latest();
            }])->firstOrFail();

        $reviews = Review::where('influencer_id', $influencer->id)->with('user')->orderBy('id', 'desc')->take(10)->get();
        
        // UPDATED: Changed socialLink to socialLinks
        $topRatedInfluencer = Influencer::active()
            ->where('id', '!=', $influencer->id)
            ->with('socialLinks.platform')
            ->orderBy('rating', 'desc')
            ->take(6)->get();

        $favoriteInfluencer = auth()->check() ? Favorite::where('user_id', auth()->id())->pluck('influencer_id')->toArray() : [];

        // SEO Content
        $seoContents = new \stdClass();
        $seoContents->keywords = is_array($influencer->skills) ? $influencer->skills : [];
        $seoContents->social_title = ($influencer->fullname ?? 'Influencer') . ' - Profile';
        $seoContents->description = strLimit(strip_tags($influencer->bio ?? 'Collaborate with this influencer on our platform.'), 150);
        $seoContents->social_description = $seoContents->description;
        
        $seoImage = getImage(getFilePath('influencer') . '/' . $influencer->image, getFileSize('influencer'));

        return view(activeTemplate() . 'influencer_profile', compact(
            'pageTitle', 
            'influencer', 
            'reviews', 
            'topRatedInfluencer', 
            'favoriteInfluencer', 
            'seoContents', 
            'seoImage'
        ));
    }

    public function reviews(Request $request) {
        $reviews = Review::where('influencer_id', $request->influencer_id)
            ->where('id', '<', $request->last_id)
            ->orderBy('id', 'desc')
            ->with('user')
            ->limit(5)->get();

        if (blank($reviews)) {
            return response()->json(['error' => 'No more reviews yet']);
        }

        $html = view(activeTemplate() . 'partials.reviews', compact('reviews'))->render();
        $lastId = $reviews->last()->id;
        return response()->json(['html' => $html, 'lastId' => $lastId]);
    }
}