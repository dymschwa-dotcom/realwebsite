<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignConversation extends Model {
    public function participant() {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
}

