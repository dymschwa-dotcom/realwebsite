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
            if (!Schema::hasColumn('influencers', 'address')) {
                $table->text('address')->nullable()->after('city');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('country_name');
            }
            if (!Schema::hasColumn('users', 'is_gst_registered')) {
                $table->boolean('is_gst_registered')->default(0)->after('tax_number');
            }
            if (!Schema::hasColumn('users', 'gst_number')) {
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
            $table->dropColumn(['address']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'is_gst_registered', 'gst_number']);
        });
    }
};
