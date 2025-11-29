<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::all();
foreach ($products as $p) {
    $path = storage_path('app/public/uploads/' . $p->productImage);
    echo $p->product_id . ' | ' . $p->productName . ' | ' . $p->productImage . ' | ' . (file_exists($path) ? 'OK' : 'MISSING') . PHP_EOL;
}
