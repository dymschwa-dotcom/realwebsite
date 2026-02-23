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
        Schema::table('influencers', function (Blueprint $table) {
            if (!Schema::hasColumn('influencers', 'is_gst_registered')) {
                $table->boolean('is_gst_registered')->default(0)->after('status');
            }
            if (!Schema::hasColumn('influencers', 'gst_number')) {
                $table->string('gst_number')->nullable()->after('is_gst_registered');
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
        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn(['is_gst_registered', 'gst_number']);
        });
    }
};
