<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignPlatform extends Model {

    public function platformName() {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function campaigns() {
        return $this->belongsToMany(Campaign::class);
    }
}
