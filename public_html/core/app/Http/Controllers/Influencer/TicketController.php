<?php

namespace App\Http\Controllers\Influencer;
use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'master';
        $this->redirectLink = 'influencer.ticket.view';
        $this->userType     = 'influencer';
        $this->column       = 'influencer_id';
        $this->user = auth()->guard('influencer')->user();
        if ($this->user) {
            $this->layout = 'master';
        }
    }
}