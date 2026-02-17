<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model {

    public function categoryName() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
