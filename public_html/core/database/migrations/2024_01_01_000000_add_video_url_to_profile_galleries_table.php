<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile_galleries', function (Blueprint $table) {
            $table->string('video_url', 255)->nullable()->after('image');
            $table->string('video_type', 50)->nullable()->after('video_url'); // youtube, vimeo, tiktok, etc.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_galleries', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->dropColumn('video_type');
        });
    }
};
