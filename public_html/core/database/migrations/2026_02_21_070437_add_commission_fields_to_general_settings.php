<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table("general_settings", function (Blueprint $table) {
            $table->decimal("brand_campaign_commission", 28, 8)->default(0);
            $table->decimal("influencer_campaign_commission", 28, 8)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table("general_settings", function (Blueprint $table) {
            $table->dropColumn(["brand_campaign_commission", "influencer_campaign_commission"]);
        });
    }
};