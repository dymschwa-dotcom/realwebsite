<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;

class ParticipantController extends Controller {
    public function all() {
        $pageTitle    = 'All Participants';
        $participants = $this->getParticipants('');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function pending() {
        $pageTitle    = 'Pending Participants';
        $participants = $this->getParticipants('pending');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function accepted() {
        $pageTitle    = 'Accepted Participants';
        $participants = $this->getParticipants('accepted');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function delivered() {
        $pageTitle    = 'Delivered Participants';
        $participants = $this->getParticipants('delivered');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function completed() {
        $pageTitle    = 'Completed Participants';
        $participants = $this->getParticipants('completed');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function reported() {
        $pageTitle    = 'Reported Participants';
        $participants = $this->getParticipants('reported');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function rejected() {
        $pageTitle    = 'Rejected Participants';
        $participants = $this->getParticipants('rejected');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }
    public function canceled() {
        $pageTitle    = 'Canceled Participants';
        $participants = $this->getParticipants('cancelled');
        return view('admin.participants.log', compact('pageTitle', 'participants'));
    }

    private function getParticipants($scope = null) {
        if ($scope) {
            $participants = Participant::$scope();
        } else {
            $participants = Participant::query();
        }
        return $participants->searchable(['participant_number', 'influencer:username', 'campaign:title'])->with(['influencer', 'campaign'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

}
