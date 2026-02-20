<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->string('engagement')->nullable();
            $table->string('avg_views')->nullable();
            $table->string('primary_gender')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn(['engagement', 'avg_views', 'primary_gender']);
        });
    }
};
