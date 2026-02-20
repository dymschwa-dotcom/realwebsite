<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
    public function campaign() {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
    public function review() {
        return $this->hasOne(Review::class, 'participant_id');
    }
    public function userConversation() {
        return $this->hasMany(CampaignConversation::class, 'participant_id')->orderBy('id', 'desc');
    }
    public function statusBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::PARTICIPATE_REQUEST_PENDING) {
                $html = '<span class="badge badge--warning">' . trans("Pending") . '</span>';
            } else if ($this->status == Status::PARTICIPATE_REQUEST_ACCEPTED) {
                $html = '<span class="badge badge--primary">' . trans("Accepted") . '</span>';
            } else if ($this->status == Status::CAMPAIGN_JOB_DELIVERED) {
                $html = '<span class="badge badge--info">' . trans("Delivered") . '</span>';
            } else if ($this->status == Status::CAMPAIGN_JOB_REPORTED) {
                $html = '<span class="badge badge--dark">' . trans("Reported") . '</span>';
            } else if ($this->status == Status::CAMPAIGN_JOB_COMPLETED) {
                $html = '<span class="badge badge--success">' . trans("Completed") . '</span>';
            } else if ($this->status == Status::PARTICIPATE_REQUEST_REJECTED) {
                $html = '<span class="badge badge--danger">' . trans("Rejected") . '</span>';
            } else if ($this->status == Status::CAMPAIGN_JOB_REFUNDED) {
                $html = '<span class="badge badge--secondary">' . trans("Refunded") . '</span>';
            } else if ($this->status == Status::CAMPAIGN_JOB_CANCELED) {
                $html = '<span class="badge badge--danger">' . trans("Cancelled") . '</span>';
            } else if ($this->status == Status::PARTICIPATE_INQUIRY) {
                $html = '<span class="badge badge--info">' . trans("Inquiry") . '</span>';
            } else if ($this->status == Status::PARTICIPATE_PROPOSAL) {
                $html = '<span class="badge badge--warning">' . trans("Proposal") . '</span>';
            }
            return $html;
        });
    }
    public function scopeInquiry($query) {
        return $query->where('status', Status::PARTICIPATE_INQUIRY);
    }
    public function scopeProposal($query) {
        return $query->where('status', Status::PARTICIPATE_PROPOSAL);
    }
    public function scopePending($query) {
        return $query->where('status', Status::PARTICIPATE_REQUEST_PENDING);
    }
    public function scopeAccepted($query) {
        return $query->where('status', Status::PARTICIPATE_REQUEST_ACCEPTED);
    }
    public function scopeDelivered($query) {
        return $query->where('status', Status::CAMPAIGN_JOB_DELIVERED);
    }
    public function scopeCompleted($query) {
        return $query->where('status', Status::CAMPAIGN_JOB_COMPLETED);
    }
    public function scopeReported($query) {
        return $query->where('status', Status::CAMPAIGN_JOB_REPORTED);
    }
    public function scopeRejected($query) {
        return $query->where('status', Status::PARTICIPATE_REQUEST_REJECTED);
    }
    public function scopeRefunded($query) {
        return $query->where('status', Status::CAMPAIGN_JOB_REFUNDED);
    }
    public function scopeCancelled($query) {
        return $query->where('status', Status::CAMPAIGN_JOB_CANCELED);
    }
    public function scopeAuthCampaign($query) {
        return $query->withWhereHas('campaign', function ($q) {
            $q->where('user_id', auth()->id())->with('user');
        });
    }
}

