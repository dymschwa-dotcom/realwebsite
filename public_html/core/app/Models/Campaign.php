<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model {

    protected $casts = [
        'content_requirements'    => 'object',
        'influencer_requirements' => 'object',
        'hash_tags'               => 'object',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function participants() {
        return $this->hasMany(Participant::class, 'campaign_id');
    }
    public function tags() {
        return $this->belongsToMany(Tag::class, 'campaign_tags');
    }
    protected function tagId(): Attribute {
        return new Attribute(
            get: fn() => $this->tags->pluck('id')->toArray()
        );
    }
    protected function tagName(): Attribute {
        return new Attribute(
            get: fn() => $this->tags->pluck('name')->toArray()
        );
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'campaign_categories');
    }
    protected function categoryId(): Attribute {
        return new Attribute(
            get: fn() => $this->categories->pluck('id')->toArray()
        );
    }
    
    protected function categoryName(): Attribute {
        return new Attribute(
            get: fn() => $this->categories->pluck('name')->toArray()
        );
    }

    public function platforms() {
        return $this->belongsToMany(Platform::class, 'campaign_platforms');
    }

    protected function platformId(): Attribute {
        return new Attribute(
            get: fn() => $this->platforms->pluck('id')->toArray()
        );
    }
    protected function platformName(): Attribute {
        return new Attribute(
            get: fn() => $this->platforms->pluck('name')->toArray()
        );
    }
    public function statusBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::CAMPAIGN_PENDING) {
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            } else if ($this->status == Status::CAMPAIGN_APPROVED) {
                $html = '<span class="badge badge--success">' . trans('Approved') . '</span>';
            } else if ($this->status == Status::CAMPAIGN_REJECTED) {
                $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
            } else {
                $html = '<span class="badge badge--dark">' . trans('Completed') . '</span>';
            }
            return $html;
        });
    }

    public function getIsUpcomingAttribute() {
        return now()->lt($this->start_date);
    }

    public function getIsRunningAttribute() {
        return now()->gte($this->start_date) && now()->lte($this->end_date);
    }

    public function getIsExpiredAttribute() {
        return now()->gt($this->end_date);
    }

    public function scopeRunning($query) {
        return $query->wheredate('start_date', '<=', now())->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query) {
        return $query->where('start_date', '>=', now());
    }

    public function scopeExpired($query) {
        return $query->where('end_date', '<', now());
    }
    public function scopeGeneral($query) {
        return $query->where('campaign_type', 'general');
    }
    public function scopeInvite($query) {
        return $query->where('campaign_type', 'invite');
    }

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
    public function scopeCampaignUpdate($query) {
        return $query->where('status', '!=', Status::CAMPAIGN_REJECTED);
    }
    public function scopeOnGoing($query) {
        return $query->approved()->running()
            ->whereHas('user', function ($query) {
                $query->active();
            })
            ->with(['platforms','categories']);
    }
}    

