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
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'gst_rate')) {
            $table->decimal('gst_rate', 5, 2)->default(15.00);
            }
            if (!Schema::hasColumn('general_settings', 'marketplace_commission_gst_rate')) {
            $table->decimal('marketplace_commission_gst_rate', 5, 2)->default(15.00);
            }
            if (!Schema::hasColumn('general_settings', 'influencer_gst_rate')) {
            $table->decimal('influencer_gst_rate', 5, 2)->default(15.00);
            }
            if (!Schema::hasColumn('general_settings', 'marketplace_gst_return_rate')) {
                $table->decimal('marketplace_gst_return_rate', 5, 2)->default(15.00);
            }
            if (!Schema::hasColumn('general_settings', 'marketplace_gst_return_to')) {
            $table->tinyInteger('marketplace_gst_return_to')->default(1)->comment('1: Influencer, 2: Marketplace');
            }
        });

        Schema::table('participants', function (Blueprint $table) {
            if (!Schema::hasColumn('participants', 'gst_amount')) {
            $table->decimal('gst_amount', 28, 8)->default(0);
            }
            if (!Schema::hasColumn('participants', 'commission_gst_amount')) {
            $table->decimal('commission_gst_amount', 28, 8)->default(0);
            }
            if (!Schema::hasColumn('participants', 'influencer_gst_amount')) {
            $table->decimal('influencer_gst_amount', 28, 8)->default(0);
            }
            if (!Schema::hasColumn('participants', 'marketplace_gst_return_amount')) {
            $table->decimal('marketplace_gst_return_amount', 28, 8)->default(0);
            }
            if (!Schema::hasColumn('participants', 'influencer_is_gst_registered')) {
                $table->tinyInteger('influencer_is_gst_registered')->default(0);
            }
            if (!Schema::hasColumn('participants', 'influencer_country_code')) {
                $table->string('influencer_country_code', 10)->nullable();
            }
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'gst_amount')) {
            $table->decimal('gst_amount', 28, 8)->default(0);
    }
            if (!Schema::hasColumn('transactions', 'commission_gst_amount')) {
                $table->decimal('commission_gst_amount', 28, 8)->default(0);
            }
            if (!Schema::hasColumn('transactions', 'influencer_gst_amount')) {
                $table->decimal('influencer_gst_amount', 28, 8)->default(0);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_gst_registered')) {
                $table->tinyInteger('is_gst_registered')->default(0);
            }
            if (!Schema::hasColumn('users', 'gst_number')) {
                $table->string('gst_number', 40)->nullable();
            }
        });

        Schema::table('influencers', function (Blueprint $table) {
            if (!Schema::hasColumn('influencers', 'is_gst_registered')) {
                $table->tinyInteger('is_gst_registered')->default(0);
            }
            if (!Schema::hasColumn('influencers', 'gst_number')) {
                $table->string('gst_number', 40)->nullable();
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
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['gst_rate', 'marketplace_commission_gst_rate', 'influencer_gst_rate', 'marketplace_gst_return_rate', 'marketplace_gst_return_to']);
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn(['gst_amount', 'commission_gst_amount', 'influencer_gst_amount', 'marketplace_gst_return_amount', 'influencer_is_gst_registered', 'influencer_country_code']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['gst_amount', 'commission_gst_amount', 'influencer_gst_amount']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_gst_registered', 'gst_number']);
        });

        Schema::table('influencers', function (Blueprint $table) {
            $table->dropColumn(['is_gst_registered', 'gst_number']);
        });
    }
};

