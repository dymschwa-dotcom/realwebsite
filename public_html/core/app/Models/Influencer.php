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
     * Attributes that are mass assignable.
     * Added bio and the new admin-only audience insight fields.
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'email',
        'mobile',
        'password',
        'image',
        'bio',
        'engagement_rate',
        'avg_reach',
        'primary_gender',
        'country_code',
        'country_name',
        'dial_code',
        'city',
        'address',
        'status',
        'kv',
        'ev',
        'sv',
        'ts',
        'tv',
    ];

    /**
     * Attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code', 'balance', 'kyc_data'
    ];

    /**
     * Attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_data'          => 'object',
        'ver_code_send_at'  => 'datetime',
        'skills'            => 'object',
        'languages'         => 'array',
    ];

    /**
     * CORE RELATIONSHIPS
     */
    public function categories() { 
        return $this->belongsToMany(Category::class, 'influencer_categories'); 
    }

    /**
     * Get the social links for the influencer.
     */
    public function socialLinks() { 
        return $this->hasMany(SocialLink::class, 'influencer_id'); 
    }

    public function galleries() { 
        return $this->hasMany(ProfileGallery::class, 'influencer_id'); 
    }

    public function reviews() { 
        return $this->hasMany(Review::class, 'influencer_id'); 
    }

    public function loginLogs() { 
        return $this->hasMany(UserLogin::class); 
    }

    public function transactions() { 
        return $this->hasMany(Transaction::class); 
    }

    public function deposits() { 
        return $this->hasMany(Deposit::class); 
    }

    public function withdrawals() { 
        return $this->hasMany(Withdrawal::class); 
    }
    
    public function services() { 
        return $this->hasMany(Service::class, 'influencer_id'); 
    }

    public function jobCompleted() { 
        return $this->hasMany(Participant::class, 'influencer_id')->where('status', Status::CAMPAIGN_JOB_COMPLETED); 
    }

    /**
     * REFERRAL RELATIONSHIPS
     */
    public function referrer() { return $this->belongsTo(self::class, 'ref_by'); }
    public function referrals() { return $this->hasMany(self::class, 'ref_by'); }
    public function allReferrals() { return $this->referrals()->with('referrer'); }

    /**
     * ACCESSORS & WORKFLOW ATTRIBUTES
     */

    /**
     * The "Verified" status check.
     */
    public function isVerified(): Attribute
    {
        return new Attribute(
            get: fn () => $this->kv == Status::KYC_VERIFIED,
        );
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn() => $this->firstname . ' ' . $this->lastname,
        );
    }

    /**
     * ADMIN & WORKFLOW SCOPES
     */
    public function scopeActive($query) { return $query->where('status', Status::USER_ACTIVE); }
    public function scopeBanned($query) { return $query->where('status', Status::USER_BAN); }
    public function scopeEmailUnverified($query) { return $query->where('ev', Status::UNVERIFIED); }
    public function scopeEmailVerified($query) { return $query->where('ev', Status::VERIFIED); }
    public function scopeMobileUnverified($query) { return $query->where('sv', Status::UNVERIFIED); }
    public function scopeMobileVerified($query) { return $query->where('sv', Status::VERIFIED); }
    
    public function scopeKycUnverified($query) { return $query->where('kv', Status::KYC_UNVERIFIED); }
    public function scopeKycPending($query) { return $query->where('kv', Status::KYC_PENDING); }

    /**
     * HELPERS
     */
    public function isOnline()
    {
        return Cache::has('last_seen' . $this->id);
    }
}