<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    use GlobalStatus;

    public function influencers() {
        return $this->belongsToMany(Influencer::class, 'influencer_categories');
    }
    public function campaignCategory() {
        return $this->hasMany(CampaignCategory::class);
    }
    public function scopeActive($query) {
        return $query->where('status', Status::ENABLE);
    }

}
