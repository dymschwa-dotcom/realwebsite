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
        Schema::table('participants', function (Blueprint $table) {
            if (!Schema::hasColumn('participants', 'influencer_is_gst_registered')) {
                $table->boolean('influencer_is_gst_registered')->default(0)->after('influencer_id');
            }
            if (!Schema::hasColumn('participants', 'influencer_country_code')) {
                $table->string('influencer_country_code', 10)->nullable()->after('influencer_is_gst_registered');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['influencer_is_gst_registered', 'influencer_country_code']);
        });
    }
};
