<?php
require __DIR__ . '/core/vendor/autoload.php';
$app = require_once __DIR__ . '/core/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

$mapping = [
    'Health & Wellness' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop',
    'Parenting & Baby'  => 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=800&auto=format&fit=crop',
];

$dir = __DIR__ . '/assets/images/category';

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
