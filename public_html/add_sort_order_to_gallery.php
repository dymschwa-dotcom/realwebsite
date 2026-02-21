<?php
require __DIR__.'/core/vendor/autoload.php';
$app = require_once __DIR__.'/core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('profile_galleries', 'sort_order')) {
    Schema::table('profile_galleries', function (Blueprint $table) {
        $table->integer('sort_order')->default(0);
    });
    echo "Column 'sort_order' added to 'profile_galleries' table.\n";
} else {
    echo "Column 'sort_order' already exists.\n";
}
