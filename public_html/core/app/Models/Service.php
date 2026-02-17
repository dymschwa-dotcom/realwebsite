<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'influencer_id',
        'title',
        'price',
        'description',
    ];

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}