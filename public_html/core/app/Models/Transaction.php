<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'influencer_id',
        'amount',
        'post_balance',
        'charge',
        'gst_amount',
        'trx_type',
        'details',
        'trx',
        'remark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

}
