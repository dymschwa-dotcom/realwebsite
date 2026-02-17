<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model {

    /**
     * The attributes that are mass assignable.
     * Updated 'url' to 'social_link' to match the actual database column name.
     */
    protected $fillable = [
        'influencer_id',
        'platform_id',
        'social_link', // FIXED: Matches the database column shown in your screenshot
        'followers',
        'channel_connect',
        'is_verified'
    ];

    /**
     * Relationship to the platform.
     */
    public function platform() {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    /**
     * Scope to find links that are not connected via API.
     */
    public function scopeNotConnect($query) {
        return $query->where('channel_connect', Status::DISABLE);
    }
}