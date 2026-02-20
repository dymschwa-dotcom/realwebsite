<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model {
    protected $fillable = ['influencer_id', 'platform_id', 'social_link', 'followers'];

    public function platform() {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function scopeNotConnect($query) {
        return $query->where('channel_connect', Status::DISABLE);
    }
}
