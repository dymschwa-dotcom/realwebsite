<?php

namespace App\Models;

use App\Traits\ApiQuery;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function influencer() {
        return $this->belongsTo(Influencer::class);
    }
}
