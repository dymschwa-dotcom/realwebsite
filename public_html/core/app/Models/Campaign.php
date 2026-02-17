<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'content_requirements'    => 'object',
        'influencer_requirements' => 'object',
        'hash_tags'               => 'object',
        // Ensure these match your DB columns for JSON data
    ];

    /**
     * Platform ID Attribute
     */
    protected function platformId(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->platforms ? $this->platforms->pluck('id')->toArray() : [];
            }
        );
    }

    /**
     * Influencer Requirements Attribute
     * Rewritten to handle the object cast properly
     */
    protected function influencerRequirements(): Attribute
{
    return Attribute::make(
        get: function ($value) {
            // 1. Decode the JSON if it's a string
            $data = is_string($value) ? json_decode($value, true) : (array) $value;

            // 2. If decoding failed or data is empty, start with a fresh array
            if (!$data || !is_array($data)) {
                $data = [];
            }

            // 3. Ensure 'gender' always exists as an array
            if (!isset($data['gender'])) {
                $data['gender'] = [];
            }

            // 4. Return as an object so your Blade templates (like @$campaign->influencer_requirements->gender) don't crash
            return (object) $data;
        }
    );
}

    // --- Relationships ---

    public function user() { 
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function influencer() { 
        return $this->belongsTo(Influencer::class, 'influencer_id'); 
    }

    public function conversation() { 
        return $this->belongsTo(Conversation::class, 'conversation_id'); 
    }

    public function participants() { 
        return $this->hasMany(Participant::class, 'campaign_id'); 
    }

    public function categories() { 
        return $this->belongsToMany(Category::class, 'campaign_categories'); 
    }

    public function platforms() { 
        return $this->belongsToMany(Platform::class, 'campaign_platforms'); 
    }

    // --- Scopes ---

    public function scopePending($query) { 
        return $query->where('status', Status::CAMPAIGN_PENDING); 
    }

    public function scopeApproved($query) { 
        return $query->where('status', Status::CAMPAIGN_APPROVED); 
    }

    public function scopeRejected($query) { 
        return $query->where('status', Status::CAMPAIGN_REJECTED); 
    }

    public function scopeInCompleted($query) { 
        return $query->where('status', Status::CAMPAIGN_INCOMPLETE); 
    }
    
    public function scopeOnGoing($query) {
        return $query->whereIn('status', [Status::CAMPAIGN_PENDING, Status::CAMPAIGN_APPROVED]);
    }

    public function scopeGeneral($query) {
        return $query->where('campaign_type', 'general');
    }

    // --- Accessors & Badges ---

    protected function statusBadge(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status == Status::CAMPAIGN_PENDING) {
                    return '<span class="badge badge--warning">' . trans('Pending') . '</span>';
                } elseif ($this->status == Status::CAMPAIGN_APPROVED) {
                    return '<span class="badge badge--success">' . trans('Approved') . '</span>';
                } elseif ($this->status == Status::CAMPAIGN_REJECTED) {
                    return '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
                }
                return '<span class="badge badge--dark">' . trans('Incomplete') . '</span>';
            }
        );
    }
}