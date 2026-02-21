<?php
include 'public_html/index.php';
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('influencer_packages', 'platform_id')) {
    Schema::table('influencer_packages', function (Blueprint $table) {
        $table->unsignedBigInteger('platform_id')->nullable();
        $table->integer('delivery_time')->default(7);
        $table->integer('post_count')->default(1);
        $table->integer('video_length')->nullable();
    });
    echo "Columns added successfully.";
} else {
    echo "Columns already exist.";
}
