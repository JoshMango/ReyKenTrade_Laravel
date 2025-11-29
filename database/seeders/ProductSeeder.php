<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing products first (disable foreign key checks to allow truncate)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Define products with their details including tire attributes
        $products = [
            [
                'name' => 'EcoSport X77',
                'brand' => 'EcoSport',
                'size' => '205/55R16',
                'type' => 'All-Season',
                'load_index' => 91,
                'speed_rating' => 'H',
                'price' => 3500.00,
                'description' => 'High-performance eco-friendly tire designed for fuel efficiency and long-lasting durability. Perfect for city driving and highway use.',
                'image' => 'EcoSport X77.png',
                'bestseller' => true,
            ],
            [
                'name' => 'FARROAD WILD HUNTER',
                'brand' => 'FARROAD',
                'size' => '265/70R17',
                'type' => 'All-Terrain',
                'load_index' => 112,
                'speed_rating' => 'S',
                'price' => 4200.00,
                'description' => 'Aggressive all-terrain tire built for off-road adventures. Excellent traction on mud, sand, and rocky surfaces.',
                'image' => 'FARROAD WILD HUNTER.png',
                'bestseller' => true,
            ],
            [
                'name' => 'FRD16',
                'brand' => 'FRD',
                'size' => '195/65R15',
                'type' => 'All-Season',
                'load_index' => 91,
                'speed_rating' => 'T',
                'price' => 2800.00,
                'description' => 'Reliable passenger tire offering smooth ride and good fuel economy. Ideal for daily commuting.',
                'image' => 'FRD16.png',
                'bestseller' => false,
            ],
            [
                'name' => 'FRD66',
                'brand' => 'FRD',
                'size' => '215/60R16',
                'type' => 'Touring',
                'load_index' => 95,
                'speed_rating' => 'H',
                'price' => 3200.00,
                'description' => 'Premium touring tire with enhanced wet weather performance. Comfortable and quiet ride.',
                'image' => 'FRD66.png',
                'bestseller' => false,
            ],
            [
                'name' => 'FRD86',
                'brand' => 'FRD',
                'size' => '225/50R17',
                'type' => 'Performance',
                'load_index' => 94,
                'speed_rating' => 'V',
                'price' => 3800.00,
                'description' => 'High-performance tire designed for sporty driving. Excellent handling and cornering capabilities.',
                'image' => 'FRD86.png',
                'bestseller' => false,
            ],
            [
                'name' => 'HK867',
                'brand' => 'HK',
                'size' => '185/70R14',
                'type' => 'All-Season',
                'load_index' => 88,
                'speed_rating' => 'T',
                'price' => 2900.00,
                'description' => 'Durable all-season tire with long tread life. Great value for money with reliable performance.',
                'image' => 'HK867.png',
                'bestseller' => false,
            ],
            [
                'name' => 'HLS1',
                'brand' => 'HLS',
                'size' => '205/60R16',
                'type' => 'Comfort',
                'load_index' => 92,
                'speed_rating' => 'H',
                'price' => 3100.00,
                'description' => 'Comfort-focused tire with low road noise. Perfect for family vehicles and long trips.',
                'image' => 'HLS1.png',
                'bestseller' => false,
            ],
            [
                'name' => 'MAXTREK EXTREME RT',
                'brand' => 'MAXTREK',
                'size' => '245/40R18',
                'type' => 'Performance',
                'load_index' => 93,
                'speed_rating' => 'W',
                'price' => 4500.00,
                'description' => 'Extreme performance tire for racing and high-speed driving. Maximum grip and precision handling.',
                'image' => 'MAXTREK EXTREME RT.png',
                'bestseller' => true,
            ],
            [
                'name' => 'MAXTREK MUD TRAC',
                'brand' => 'MAXTREK',
                'size' => '285/75R16',
                'type' => 'Mud Terrain',
                'load_index' => 116,
                'speed_rating' => 'Q',
                'price' => 4800.00,
                'description' => 'Heavy-duty mud terrain tire for serious off-road enthusiasts. Deep tread pattern for maximum traction.',
                'image' => 'MAXTREK MUD TRAC.png',
                'bestseller' => false,
            ],
            [
                'name' => 'Montreal Eco 2',
                'brand' => 'Montreal',
                'size' => '195/65R15',
                'type' => 'Eco',
                'load_index' => 91,
                'speed_rating' => 'H',
                'price' => 3600.00,
                'description' => 'Eco-friendly tire with advanced technology for reduced rolling resistance. Better fuel economy and lower emissions.',
                'image' => 'Montreal Eco 2.png',
                'bestseller' => false,
            ],
            [
                'name' => 'P309',
                'brand' => 'PowerTrac',
                'size' => '175/70R14',
                'type' => 'All-Season',
                'load_index' => 84,
                'speed_rating' => 'T',
                'price' => 2700.00,
                'description' => 'Budget-friendly tire with good all-around performance. Reliable for everyday use.',
                'image' => 'P309.png',
                'bestseller' => false,
            ],
            [
                'name' => 'POWER TREC TIRES P275',
                'brand' => 'PowerTrec',
                'size' => '275/40R20',
                'type' => 'Performance',
                'load_index' => 106,
                'speed_rating' => 'Y',
                'price' => 4100.00,
                'description' => 'Powerful performance tire with enhanced grip and stability. Designed for high-performance vehicles.',
                'image' => 'POWER TREC TIRES P275.png',
                'bestseller' => false,
            ],
            [
                'name' => 'POWERTRAC',
                'brand' => 'PowerTrac',
                'size' => '235/65R17',
                'type' => 'All-Terrain',
                'load_index' => 104,
                'speed_rating' => 'T',
                'price' => 3900.00,
                'description' => 'Versatile all-terrain tire suitable for both on-road and light off-road use. Balanced performance.',
                'image' => 'POWERTRAC.png',
                'bestseller' => false,
            ],
            [
                'name' => 'Sks Tire',
                'brand' => 'SKS',
                'size' => '205/55R16',
                'type' => 'All-Season',
                'load_index' => 91,
                'speed_rating' => 'H',
                'price' => 3000.00,
                'description' => 'Quality tire with excellent tread life and reliable performance. Great for standard vehicles.',
                'image' => 'Sks Tire.png',
                'bestseller' => false,
            ],
            [
                'name' => 'SP909',
                'brand' => 'SP',
                'size' => '225/45R17',
                'type' => 'Performance',
                'load_index' => 94,
                'speed_rating' => 'V',
                'price' => 3400.00,
                'description' => 'Sport performance tire with responsive handling and good cornering stability.',
                'image' => 'SP909.png',
                'bestseller' => false,
            ],
            [
                'name' => 'Tire Example',
                'brand' => 'Generic',
                'size' => '185/65R15',
                'type' => 'All-Season',
                'load_index' => 88,
                'speed_rating' => 'T',
                'price' => 2500.00,
                'description' => 'Standard tire example with basic features. Suitable for regular driving conditions.',
                'image' => 'Tire Example.png',
                'bestseller' => false,
            ],
            [
                'name' => 'Toyota Tire',
                'brand' => 'Toyota',
                'size' => '215/60R16',
                'type' => 'OEM',
                'load_index' => 95,
                'speed_rating' => 'H',
                'price' => 3300.00,
                'description' => 'OEM-style tire designed for Toyota vehicles. Reliable performance and good fuel efficiency.',
                'image' => 'Toyota Tire.png',
                'bestseller' => false,
            ],
            [
                'name' => 'WILDRANGER A T',
                'brand' => 'WildRanger',
                'size' => '265/70R17',
                'type' => 'All-Terrain',
                'load_index' => 112,
                'speed_rating' => 'S',
                'price' => 4400.00,
                'description' => 'All-terrain tire for SUVs and trucks. Excellent for both highway and off-road adventures.',
                'image' => 'WILDRANGER A T.png',
                'bestseller' => false,
            ],
            [
                'name' => 'WILDRANGER MT',
                'brand' => 'WildRanger',
                'size' => '285/75R16',
                'type' => 'Mud Terrain',
                'load_index' => 116,
                'speed_rating' => 'Q',
                'price' => 4700.00,
                'description' => 'Mud terrain tire with aggressive tread pattern. Built for extreme off-road conditions.',
                'image' => 'WILDRANGER MT.png',
                'bestseller' => false,
            ],
            [
                'name' => 'WILDRANGER MT2',
                'brand' => 'WildRanger',
                'size' => '285/75R16',
                'type' => 'Mud Terrain',
                'load_index' => 118,
                'speed_rating' => 'Q',
                'price' => 4900.00,
                'description' => 'Advanced mud terrain tire with improved durability and traction. Premium off-road performance.',
                'image' => 'WILDRANGER MT2.png',
                'bestseller' => false,
            ],
        ];

        // Source directory for old images
        $sourceDir = dirname(dirname(dirname(__DIR__))) . '/oldReykentrade/uploads';
        // Destination directory in Laravel storage
        $destDir = storage_path('app/public/uploads');

        // Create destination directory if it doesn't exist
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach ($products as $productData) {
            $sourcePath = $sourceDir . '/' . $productData['image'];
            $destPath = $destDir . '/' . $productData['image'];

            // Copy image if it exists
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destPath);
            }

            // Create product in database
            Product::create([
                'productName' => $productData['name'],
                'brand' => $productData['brand'],
                'size' => $productData['size'],
                'type' => $productData['type'],
                'load_index' => $productData['load_index'],
                'speed_rating' => $productData['speed_rating'],
                'productPrice' => $productData['price'],
                'productDesc' => $productData['description'],
                'productImage' => $productData['image'],
                'bestseller' => $productData['bestseller'],
            ]);
        }

        $this->command->info('Products seeded successfully with tire attributes!');
    }
}
