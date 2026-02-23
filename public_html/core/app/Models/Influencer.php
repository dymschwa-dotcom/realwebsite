<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\InfluencerNotify;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Influencer extends Authenticatable
{
    use HasApiTokens, InfluencerNotify;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','ver_code','balance','kyc_data'
    ];

    /**allReferrals
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_data' => 'object',
        'ver_code_send_at' => 'datetime',
        'skills'            => 'object',
        'languages'         => 'array',
        'is_gst_registered' => 'boolean',
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'influencer_categories');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id','desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status','!=',Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status','!=',Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function campaignReviewData() {
        return $this->hasManyThrough(Review::class, Participant::class, 'influencer_id', 'participant_id', 'id', 'id');
    }

    public function socialLink() {
        return $this->hasMany(SocialLink::class, 'influencer_id');
    }

    public function jobCompleted() {
        return $this->hasMany(Participant::class, 'influencer_id')->where('status', Status::CAMPAIGN_JOB_COMPLETED);
    }

    public function jobRunning() {
        return $this->hasMany(Participant::class, 'influencer_id')->whereIn('status', [Status::PARTICIPATE_REQUEST_ACCEPTED, Status::CAMPAIGN_JOB_DELIVERED]);
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'influencer_id');
    }

    public function referrer() {
        return $this->belongsTo(self::class, 'ref_by');
    }

    public function referrals() {
        return $this->hasMany(self::class, 'ref_by');
    }

    public function allReferrals() {
        return $this->referrals()->with('referrer');
    }

    public function isOnline() {
        return Cache::has('last_seen' . $this->id);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    protected function categoryId(): Attribute {
        return new Attribute(
            get: fn() => $this->categories->pluck('id')->toArray()
        );
    }


    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn () => $this->dial_code . $this->mobile,
        );
    }

    public function galleries() {
        return $this->hasMany(ProfileGallery::class, 'influencer_id')->orderBy('sort_order', 'asc');
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED)->where('profile_complete', Status::YES)->where('profile_step', 3);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance','>', 0);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function packages() {
        return $this->hasMany(InfluencerPackage::class, 'influencer_id');
    }
}

