<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileGallery extends Model {
    public function influencer() {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
}
