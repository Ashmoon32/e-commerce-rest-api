<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Product::create([
            'name' => 'Classic White T-Shirt',
            'slug' => 'classic-white-t-shirt',
            'description' => '100% cotton, comfortable fit',
            'price' => 15000,
            'stock_quantity' => 100,
            'category_id' => 4, // Short Sleeve
            'image_urls' => ['https://example.com/white-tshirt.jpg'],
        ]);

        Product::create([
            'name' => 'Classic Black T-Shirt',
            'slug' => 'classic-black-t-shirt',
            'description' => '100% cotton, comfortable fit',
            'price' => 16000,
            'stock_quantity' => 90,
            'category_id' => 4, // Short Sleeve
            'image_urls' => ['https://example.com/black-tshirt.jpg'],
        ]);

        Product::create([
            'name' => 'Classic Blue T-Shirt',
            'slug' => 'classic-blue-t-shirt',
            'description' => '100% cotton, comfortable fit',
            'price' => 16000,
            'stock_quantity' => 100,
            'category_id' => 4, // Short Sleeve
            'image_urls' => ['https://example.com/blue-tshirt.jpg'],
        ]);

        Product::create([
            'name' => 'Black Denim Jacket',
            'slug' => 'black-denim-jacket',
            'description' => 'Premium denim material',
            'price' => 45000,
            'stock_quantity' => 50,
            'category_id' => 3, // Long Sleeve
            'image_urls' => ['https://example.com/denim-jacket.jpg'],
        ]);

        Product::create([
            'name' => 'White Denim Jacket',
            'slug' => 'white-denim-jacket',
            'description' => 'Premium denim material',
            'price' => 45000,
            'stock_quantity' => 50,
            'category_id' => 3, // Long Sleeve
            'image_urls' => ['https://example.com/denim-jacket.jpg'],
        ]);

        Product::create([
            'name' => 'Summer Floral Dress',
            'slug' => 'summer-floral-dress',
            'description' => 'Lightweight, perfect for summer',
            'price' => 35000,
            'stock_quantity' => 30,
            'category_id' => 6, // Dresses
            'image_urls' => ['https://example.com/floral-dress.jpg'],
        ]);
    }
}