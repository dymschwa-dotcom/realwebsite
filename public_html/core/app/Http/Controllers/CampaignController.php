<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignTag;
use App\Models\Category;
use App\Models\InviteCampaign;
use App\Models\Page;
use App\Models\Platform;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class CampaignController extends Controller {

    public function all(Request $request) {
        $pageTitle  = 'All Campaign';
        $platforms  = Platform::active()->orderBy('name')->get();
        $campaigns  = Campaign::onGoing()->general();
        $campaigns  = $this->getFilterCampaign($campaigns, $platforms);
        $campaigns  = $campaigns->searchable(['title'])->withCount('participants')->orderBy('id', 'desc')->paginate(getPaginate());
        $countries  = User::active()->whereHas('campaigns')->pluck('country_name')->unique();
        $categories = Category::active()->orderBy('name')->get();
        $sections   = Page::where('tempname', activeTemplate())->where('slug', 'campaign')->first();
        return view('Template::campaigns', compact('pageTitle', 'campaigns', 'platforms', 'countries', 'categories', 'sections'));
    }

        protected function getFilterCampaign($campaigns, $platforms) {
        $request = request();

        // 1. CATEGORIES (Combinable - OR within group)
        if ($request->category) {
            $categoryIds = Category::active()->whereIn('slug', (array)$request->category)->pluck('id')->toArray();
            $campaigns->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('campaign_categories.category_id', $categoryIds);
            });
        }

        // 2. PLATFORMS (Combinable - OR within group)
        $platformNames = array_filter(array_unique((array)$request->platform_name));
        if ($request->platform) $platformNames[] = $request->platform;

        if (!empty($platformNames)) {
            $platformIds = Platform::active()->whereIn('name', $platformNames)->pluck('id')->toArray();
            $campaigns->whereHas('platforms', function ($query) use ($platformIds) {
                $query->whereIn('campaign_platforms.platform_id', $platformIds);
            });
        }

        // 3. FOLLOWER RANGE (Combinable - OR within group)
        if ($request->follower_range) {
            $followerRanges = (array)$request->follower_range;
            $campaigns->where(function ($query) use ($platforms, $followerRanges) {
                foreach ($followerRanges as $range) {
                    if (!$range) continue;
                    
                    if ($range == 1000000) {
                        foreach ($platforms as $platform) {
                            $social = strtolower($platform->name);
                            $query->orWhere("influencer_requirements->follower_{$social}_start", '>=', 1000000);
                        }
                    } else {
                        $rangeValues = explode('_', $range);
                        $startRange  = @$rangeValues[0] * 1000;
                        $endRange    = @$rangeValues[1] * 1000;

                        foreach ($platforms as $platform) {
                            $social = strtolower($platform->name);
                            $query->orWhere(function ($q) use ($social, $startRange, $endRange) {
                                $q->where("influencer_requirements->follower_{$social}_start", '>=', $startRange)
                                  ->where("influencer_requirements->follower_{$social}_end", '<=', $endRange);
                            });
                        }
                    }
                }
            });
        }

        // 4. GENDER (Combinable - OR within group)
        if ($request->gender) {
            $genders = (array)$request->gender;
            $campaigns->where(function ($query) use ($genders) {
                foreach ($genders as $gender) {
                    $query->orWhereJsonContains('influencer_requirements->gender', $gender);
                }
            });
        }

        // 5. COUNTRY (Combinable - OR within group)
        if ($request->country) {
            $countries = (array)$request->country;
            $campaigns->whereHas('user', function ($query) use ($countries) {
                $query->where(function ($q) use ($countries) {
                    foreach ($countries as $country) {
                        $q->orWhereJsonContains('address->country', $country);
                    }
                });
            });
        }

        if ($request->eligible_only && authInfluencer()) {
        $influencer = authInfluencer();
                if (!$influencer->kv) {
                $campaigns->where('id', 0);
            } else {
                $campaigns->whereJsonContains('influencer_requirements->gender', $influencer->gender);

                $socialLinks = $influencer->socialLink()->with('platform')->get();
                if ($socialLinks->isEmpty()) {
                    $campaigns->where('id', 0);
                } else {
                    $influencerPlatformIds = $socialLinks->pluck('platform_id')->toArray();

                    // Influencer must have all platforms required by the campaign
                    $campaigns->whereDoesntHave('platforms', function ($q) use ($influencerPlatformIds) {
                        $q->whereNotIn('platforms.id', $influencerPlatformIds);
                    });

                    // Follower range check for each platform the influencer has
                    foreach ($socialLinks as $link) {
                        $pName     = strtolower($link->platform->name);
                        $followers = $link->followers;

                        $campaigns->where(function ($q) use ($pName, $followers) {
                            $startKey = "follower_{$pName}_start";
                            $endKey   = "follower_{$pName}_end";

                            $q->whereDoesntHave('platforms', function ($sq) use ($pName) {
                                $sq->where('name', $pName);
                            })->orWhere(function ($sq) use ($startKey, $endKey, $followers) {
                                $sq->whereRaw("CAST(JSON_EXTRACT(influencer_requirements, '$.$startKey') AS UNSIGNED) <= ?", [$followers])
                                    ->whereRaw("CAST(JSON_EXTRACT(influencer_requirements, '$.$endKey') AS UNSIGNED) >= ?", [$followers]);
                            });
                        });
                    }

                    // Check if influencer is already invited (logic from detail says they are NOT eligible for general if invited)
                    $campaigns->whereDoesntHave('invites', function ($q) use ($influencer) {
                        $q->where('influencer_id', $influencer->id)->where('status', 0);
                    });
                }
            }
        }

        if ($request->tag) {
            $tag = Tag::where('name', $request->tag)->first();
            if($tag) {
                $campaignIds = CampaignTag::where('tag_id', $tag->id)->pluck('campaign_id')->toArray();
                $campaigns->whereIn('id', $campaignIds);
            }
        }

        return $campaigns;
    }

    public function detail($slug, $id) {

        $campaign   = Campaign::onGoing()->findOrFail($id);
        $influencer = authInfluencer();
        abort_if(!$influencer && $campaign->campaign_type == 'invite', 404);

        $pageTitle = 'Campaign Detail';
        $eligible  = false;
        $alreadyApplied = false;

        if ($influencer) {
            $alreadyApplied = $campaign->participants()->where('influencer_id', $influencer->id)->exists();
            $isInvitedCampaign = InviteCampaign::inactive()->where('campaign_id', $campaign->id)->where('influencer_id', $influencer->id)->exists();

            if ($campaign->campaign_type == 'invite') {
                $eligible = $isInvitedCampaign;
            } else {
                if ($isInvitedCampaign) {
                    $eligible = false;
                } else {
                    $eligible = true;
                }

                $gender = (array) $campaign->influencer_requirements->gender;
                if (!in_array($influencer->gender, $gender)) {
                    $eligible = false;
                }
                if (!$influencer->socialLink || $influencer->socialLink->count() == 0) {
                    $eligible = false;
                }
                if (!$influencer->kv) {
                    $eligible = false;
                }

                foreach ($campaign->platforms as $platform) {
                    $social = $influencer->socialLink->where('platform_id', $platform->id)->first();
                    if (!$social) {
                        $eligible = false;
                        continue;
                    }

                    $pName              = strtolower($platform->name);
                    $startFollowerRange = 'follower_' . $pName . '_start';
                    $endFollowerRange   = 'follower_' . $pName . '_end';

                    $campaignStartRange = @$campaign->influencer_requirements->$startFollowerRange ?? 0;
                    $campaignEndRange   = @$campaign->influencer_requirements->$endFollowerRange ?? 1000000000;

                    if ($social->followers < $campaignStartRange || $social->followers > $campaignEndRange) {
                        $eligible = false;
                    }
                }
            }
        }

        $seoContents                     = new \stdClass();
        $seoContents->keywords           = $campaign->tagName ?? [];
        $seoContents->social_title       = $campaign->title;
        $seoContents->description        = strLimit(strip_tags($campaign->description), 150);
        $seoContents->social_description = strLimit(strip_tags($campaign->description), 150);
        $seoImage                        = getImage(getFilePath('campaign') . '/' . $campaign->image, getFileSize('campaign'));
        return view('Template::campaign_detail', compact('pageTitle', 'campaign', 'eligible', 'seoContents', 'seoImage', 'alreadyApplied'));
    }
}