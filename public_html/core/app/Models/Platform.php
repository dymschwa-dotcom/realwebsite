<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model {
    use GlobalStatus;

    public function campaignPlatform() {
        return $this->hasMany(CampaignPlatform::class);
    }

    public function campaigns() {
        return $this->belongsToMany(Campaign::class);
    }
}
