<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 16 Pro',
                'price' => 129000,
                'stock' => 40,
            ],
            [
                'name' => 'Samsung S24 Ultra',
                'price' => 118000,
                'stock' => 35,
            ],
            [
                'name' => 'OnePlus 12',
                'price' => 65000,
                'stock' => 60,
            ],
            [
                'name' => 'Nothing Phone 2A',
                'price' => 28000,
                'stock' => 100,
            ],
            [
                'name' => 'Redmi Note 14 Pro',
                'price' => 22000,
                'stock' => 120,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
