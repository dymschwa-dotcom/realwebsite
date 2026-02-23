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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'gst_amount')) {
                $table->decimal('gst_amount', 28, 8)->default(0)->after('charge');
            }
        });

        Schema::table('participants', function (Blueprint $table) {
            if (!Schema::hasColumn('participants', 'gst_amount')) {
                $table->decimal('gst_amount', 28, 8)->default(0)->after('budget');
            }
            if (!Schema::hasColumn('participants', 'commission_gst_amount')) {
                $table->decimal('commission_gst_amount', 28, 8)->default(0)->after('gst_amount');
            }
            if (!Schema::hasColumn('participants', 'influencer_gst_amount')) {
                $table->decimal('influencer_gst_amount', 28, 8)->default(0)->after('commission_gst_amount');
            }
            if (!Schema::hasColumn('participants', 'marketplace_gst_return_amount')) {
                $table->decimal('marketplace_gst_return_amount', 28, 8)->default(0)->after('influencer_gst_amount');
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('gst_amount');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn([
                'gst_amount', 
                'commission_gst_amount', 
                'influencer_gst_amount', 
                'marketplace_gst_return_amount'
            ]);
        });
    }
};
