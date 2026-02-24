<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->string('stripe_account_id')->nullable();
            $table->boolean('stripe_onboarded')->default(false);
        });
    }

    public function down()
    {
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn(['stripe_account_id', 'stripe_onboarded']);
        });
    }
};
