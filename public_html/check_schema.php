<?php
require __DIR__.'/core/vendor/autoload.php';
$app = require_once __DIR__.'/core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

try {
    echo "Updating 'messages' table schema...\n";

    // Applying the requested ALTER TABLE statement
    DB::statement("
        ALTER TABLE messages
        ADD COLUMN type VARCHAR(50) DEFAULT 'text' AFTER message,
        ADD COLUMN title VARCHAR(255) NULL AFTER message,
        ADD COLUMN participant_id BIGINT UNSIGNED NULL AFTER type;
    ");

    echo "Checking 'messages' table schema...\n";

    // Executing raw SQL as requested
    $columns = DB::select('SHOW COLUMNS FROM messages');
        echo "\nDetails:\n";
        foreach ($columns as $col) {
        echo "- " . $col->Field . " (" . $col->Type . ")\n";
        }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

