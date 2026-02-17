<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class InviteCampaign extends Model {
    use GlobalStatus;

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
