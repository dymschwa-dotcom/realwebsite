<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
    public function participant() {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
    public function campaign() {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
