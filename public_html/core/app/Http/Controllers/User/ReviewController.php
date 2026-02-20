<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {

    public function index() {
        $pageTitle = 'All Reviews';
        $reviews   = Review::where('user_id', auth()->id())->whereNot('participant_id', 0)->with('influencer:id,username', 'participant')->searchable(['participant:participant_number', 'influencer:username'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.review.index', compact('pageTitle', 'reviews'));
    }

    public function reviewForm($participantId, $id = 0) {
        $participant = Participant::completed()->findOrFail($participantId);

        if ($participant->review && $id == 0) {
            $notify[] = ['error', 'Already reviewed this influencer'];
            return back()->withNotify($notify);
        }

        $pageTitle = 'Review for - ' . @$participant->influencer->username;
        return view('Template::user.review.form', compact('pageTitle', 'participant'));
    }

    public function add(Request $request, $participantId, $id = 0) {
        $participant = Participant::authCampaign()->findOrFail($participantId);
        if ($participant->review && !$id) {
            $notify[] = ['error', 'Already reviewed this influencer'];
            return back()->withNotify($notify);
        }
        $request->validate([
            'star'   => 'required|integer|min:1|max:5',
            'review' => 'required|string',
        ]);
        if ($id) {
            $review = $participant->review;
        } else {
            $review = new Review();
        }
        $this->insertReview($review, $participant, 'participant_id');
        $influencer = $participant->influencer;
        $this->influencerReviewUpdate($influencer);
        if (!$id) {
            $influencer->increment('total_review');
        }

        recentActivity('Review added successfully', auth()->id());
        recentActivity(auth()->user()->username . ' has reviewed for your campaign job', 0, $influencer->id);

        $notify[] = ['success', 'Review added successfully'];
        return to_route('user.participant.detail', $participant->id)->withNotify($notify);
    }

    protected function insertReview($review, $data, $column) {
        $request               = request();
        $review->user_id       = auth()->id();
        $review->influencer_id = $data->influencer_id;
        $review->$column       = $data->id;
        $review->star          = $request->star;
        $review->review        = $request->review;
        $review->save();
    }

    public function remove($id) {
        $review     = Review::where('user_id', auth()->id())->findOrFail($id);
        $influencer = $review->influencer;
        $review->delete();
        $this->influencerReviewUpdate($influencer);
        $influencer->decrement('total_review');

        recentActivity('You removed influencer review', auth()->id());
        recentActivity(auth()->user()->username . ' has removed review for your campaign job', 0, $influencer->id);

        $notify[] = ['success', 'Review removed successfully'];
        return back()->withN.favoriteBtnotify($notify);
    }
    protected function influencerReviewUpdate($influencer) {
        $totalStar   = $influencer->campaignReviewData->sum('star');
        $totalReview = $influencer->campaignReviewData->count();

        if ($totalReview != 0) {
            $avgRating = $totalStar / $totalReview;
        } else {
            $avgRating = request()->star ?? 0;
        }
        $influencer->rating = $avgRating;
        $influencer->save();
    }
}
