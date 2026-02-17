<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    use GlobalStatus;

    public function campaigns() {
        return $this->belongsToMany(Campaign::class, 'campaign_tags');
    }

    public function campaignTag() {
        return $this->hasMany(CampaignTag::class);
    }
}
