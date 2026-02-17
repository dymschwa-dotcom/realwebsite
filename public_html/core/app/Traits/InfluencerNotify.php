<?php
namespace App\Traits;

use App\Constants\Status;

trait InfluencerNotify {
    public static function notifyToUser() {
        return [
            'allUsers'              => 'All Influencer',
            'selectedUsers'         => 'Selected Influencer',
            'kycUnverified'         => 'Kyc Unverified Influencer',
            'kycVerified'           => 'Kyc Verified Influencer',
            'kycPending'            => 'Kyc Pending Influencer',
            'withBalance'           => 'With Balance Influencer',
            'emptyBalanceUsers'     => 'Empty Balance Influencer',
            'twoFaDisableUsers'     => '2FA Disable Influencer',
            'twoFaEnableUsers'      => '2FA Enable Influencer',
            'pendingTicketUser'     => 'Pending Ticket Influencer',
            'answerTicketUser'      => 'Answer Ticket Influencer',
            'closedTicketUser'      => 'Closed Ticket Influencer',
            'notLoginUsers'         => 'Last Few Days Not Login Influencer',
            'hasWithdrawUsers'      => 'Withdraw Influencer',
            'pendingWithdrawUsers'  => 'Pending Withdraw Influencer',
            'rejectedWithdrawUsers' => 'Rejected Withdraw Influencer',
            'pendingCampaignJob'    => 'Pending Campaign Job Influencer',
            'acceptedCampaignJob'   => 'Accepted Campaign Job Influencer',
            'deliveredCampaignJob'  => 'Delivered Campaign Job Influencer',
            'completedCampaignJob'  => 'Completed Campaign Job Influencer',
            'refundedCampaignJob'   => 'Refunded Campaign Job Influencer',
            'canceledCampaignJob'   => 'Canceled Campaign Job Influencer',
            'reportedCampaignJob'   => 'Reported Campaign Job Influencer',
            'rejectedCampaignJob'   => 'Rejected Campaign Job Influencer',
        ];
    }

    public function scopeSelectedUsers($query) {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllUsers($query) {
        return $query;
    }

    public function scopeEmptyBalanceUsers($query) {
        return $query->where('balance', '<=', 0);
    }

    public function scopeTwoFaDisableUsers($query) {
        return $query->where('ts', Status::DISABLE);
    }

    public function scopeTwoFaEnableUsers($query) {
        return $query->where('ts', Status::ENABLE);
    }

    public function scopeHasWithdrawUsers($query) {
        return $query->whereHas('withdrawals', function ($q) {
            $q->approved();
        });
    }

    public function scopePendingWithdrawUsers($query) {
        return $query->whereHas('withdrawals', function ($q) {
            $q->pending();
        });
    }

    public function scopeRejectedWithdrawUsers($query) {
        return $query->whereHas('withdrawals', function ($q) {
            $q->rejected();
        });
    }

    public function scopePendingTicketUser($query) {
        return $query->whereHas('tickets', function ($q) {
            $q->where('influencer_id', '!=', 0)->whereIn('status', [Status::TICKET_OPEN, Status::TICKET_REPLY]);
        });
    }

    public function scopeClosedTicketUser($query) {
        return $query->whereHas('tickets', function ($q) {
            $q->where('influencer_id', '!=', 0)->where('status', Status::TICKET_CLOSE);
        });
    }

    public function scopeAnswerTicketUser($query) {
        return $query->whereHas('tickets', function ($q) {
            $q->where('influencer_id', '!=', 0)->where('status', Status::TICKET_ANSWER);
        });
    }

    public function scopeNotLoginUsers($query) {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

    public function scopeKycVerified($query) {
        return $query->where('kv', Status::KYC_VERIFIED);
    }

    public function scopePendingCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->pending();
        });
    }
    public function scopeAcceptedCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->accepted();
        });
    }
    public function scopeDeliveredCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->delivered();
        });
    }
    public function scopeCompletedCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->completed();
        });
    }
    public function scopeRefundedCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->refunded();
        });
    }
    public function scopeCanceledCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->canceled();
        });
    }
    public function scopeReportedCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->reported();
        });
    }
    public function scopeRejectedCampaignJob($query) {
        return $query->whereHas('participants', function ($q) {
            $q->rejected();
        });
    }
}
