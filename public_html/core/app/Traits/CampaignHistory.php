<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Campaign;

trait CampaignHistory {
    public function index() {
        $pageTitle = 'All Campaign';
        $campaigns = $this->getCampaignData('');
        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns'));
    }
    public function pending() {
        $pageTitle = 'Pending Campaign';
        $campaigns = $this->getCampaignData('pending');
        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns'));
    }
    public function approved() {
        $pageTitle = 'Approved Campaign';
        $campaigns = $this->getCampaignData('approved');
        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns'));
    }
    public function rejected() {
        $pageTitle = 'Rejected Campaign';
        $campaigns = $this->getCampaignData('rejected');
        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns'));
    }
    public function incomplete() {
        $pageTitle = 'Incomplete Campaign';
        $campaigns = $this->getCampaignData('incompleted');
        return view('Template::user.campaign.history', compact('pageTitle', 'campaigns'));
    }

    private function getCampaignData($scope) {
        $campaigns = Campaign::where('user_id', auth()->id());
        if ($scope) {
            $campaigns->$scope();
        }
        return $campaigns = $campaigns->searchable(['title'])->withCount(['participants', 'participants as participants_count_pending' => function ($q) {
            $q->where('status', Status::PARTICIPATE_REQUEST_PENDING);
        }])->orderBy('id', 'desc')->paginate(getPaginate());
    }
}