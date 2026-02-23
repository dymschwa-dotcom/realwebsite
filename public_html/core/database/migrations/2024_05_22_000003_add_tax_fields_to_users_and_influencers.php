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
            if (!Schema::hasColumn('influencers', 'tax_number')) {
                $table->string('tax_number')->nullable()->after('gst_number');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('username');
            }
            if (!Schema::hasColumn('users', 'tax_number')) {
                $table->string('tax_number')->nullable()->after('company_name');
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
            $table->dropColumn('tax_number');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'tax_number']);
        });
    }
};
