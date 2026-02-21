<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/core/vendor/autoload.php';
$app = require_once __DIR__ . '/core/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    if (!Schema::hasTable('plans')) {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 28, 8)->default(0);
            $table->integer('campaign_limit')->default(0); 
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        echo "Table 'plans' created.\n";
    }

    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'plan_id')) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('balance');
            echo "Column 'plan_id' added to 'users'.\n";
        }
        if (!Schema::hasColumn('users', 'plan_ends_at')) {
            $table->timestamp('plan_ends_at')->nullable()->after('plan_id');
            echo "Column 'plan_ends_at' added to 'users'.\n";
        }
    });

    // Seed default plans
    DB::table('plans')->updateOrInsert(['id' => 1], [
        'name' => 'Starter',
        'price' => 49.00,
        'campaign_limit' => 3,
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('plans')->updateOrInsert(['id' => 2], [
        'name' => 'Professional',
        'price' => 99.00,
        'campaign_limit' => -1, // Unlimited
        'status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "Default plans seeded.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
