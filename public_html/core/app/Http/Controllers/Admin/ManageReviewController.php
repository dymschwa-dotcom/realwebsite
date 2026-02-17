<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ManageReviewController extends Controller {
    public function index() {
        $pageTitle = 'All Review';
        $reviews   = Review::whereNot('participant_id', 0)->with('influencer:id,username', 'user:id,username', 'participant.campaign:id,title')->searchable(['user:username', 'influencer:username', 'participant:participant_number', 'participant.campaign:title'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.reviews.index', compact('pageTitle', 'reviews'));
    }
    public function remove($id) {
        $review     = Review::findOrFail($id);
        $influencer = $review->influencer;
        $review->delete();

        $totalStar   = $influencer->campaignReviewData->sum('star');
        $totalReview = $influencer->campaignReviewData->count();

        if ($totalReview != 0) {
            $avgRating = $totalStar / $totalReview;
        } else {
            $avgRating = 0;
        }
        $influencer->rating = $avgRating;
        $influencer->save();

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withNotify($notify);
    }

}
