<?php
require __DIR__ . '/core/vendor/autoload.php';
$app = require_once __DIR__ . '/core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$mapping = [
    'Lifestyle' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop',
    'Fashion'   => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800&auto=format&fit=crop',
    'Beauty'    => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800&auto=format&fit=crop',
    'Tech'      => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop',
    'Fitness'   => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800&auto=format&fit=crop',
    'Travel'    => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800&auto=format&fit=crop',
    'Gaming'    => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800&auto=format&fit=crop',
    'Food'      => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800&auto=format&fit=crop',
];

$dir = __DIR__ . '/assets/images/category';
if (!file_exists($dir)) {
    mkdir($dir, 0755, true);
}

foreach ($mapping as $name => $url) {
    $category = Category::where('name', 'LIKE', "%$name%")->first();
    if ($category) {
        echo "Updating $name...\n";
        $filename = uniqid() . '.jpg';
        $path = $dir . '/' . $filename;
        
        $content = file_get_contents($url);
        if ($content) {
            file_put_contents($path, $content);
            $category->image = $filename;
            $category->save();
            echo "Successfully updated $name with image $filename\n";
        } else {
            echo "Failed to download image for $name\n";
        }
    } else {
        echo "Category $name not found in database.\n";
    }
}
