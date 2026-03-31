<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {
    protected $guarded = ['id'];

    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
}
