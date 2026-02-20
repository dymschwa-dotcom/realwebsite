<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('influencer_packages', 'platform_id')) {
            Schema::table('influencer_packages', function (Blueprint $table) {
                $table->unsignedBigInteger('platform_id')->nullable();
                $table->integer('delivery_time')->default(7);
                $table->integer('post_count')->default(1);
                $table->integer('video_length')->nullable();
            });
        }

        if (!Schema::hasColumn('influencers', 'region')) {
            Schema::table('influencers', function (Blueprint $table) {
                $table->string('region')->nullable()->after('city');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('influencer_packages', function (Blueprint $table) {
            $table->dropColumn(['platform_id', 'delivery_time', 'post_count', 'video_length']);
        });
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn(['region']);
        });
    }
};

