<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('deposits', 'gst_amount')) {
                $blueprint->decimal('gst_amount', 28, 8)->default(0)->after('amount');
            }
            if (!Schema::hasColumn('deposits', 'service_fee')) {
                $blueprint->decimal('service_fee', 28, 8)->default(0)->after('gst_amount');
            }
        });

        Schema::table('transactions', function (Blueprint $blueprint) {
            if (!Schema::hasColumn('transactions', 'gst_amount')) {
                $blueprint->decimal('gst_amount', 28, 8)->default(0)->after('amount');
            }
            if (!Schema::hasColumn('transactions', 'service_fee')) {
                $blueprint->decimal('service_fee', 28, 8)->default(0)->after('gst_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['gst_amount', 'service_fee']);
        });
        Schema::table('transactions', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['gst_amount', 'service_fee']);
        });
    }
};
