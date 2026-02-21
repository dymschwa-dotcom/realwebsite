<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->decimal('price', 28, 8)->default(0);
            $blueprint->integer('campaign_limit')->default(0); // -1 for unlimited
            $blueprint->boolean('status')->default(1);
            $blueprint->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('balance');
            $table->timestamp('plan_ends_at')->nullable()->after('plan_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plans');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['plan_id', 'plan_ends_at']);
        });
    }
};
