<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Product 1',
            'description' => 'Description 1',
            'price' => 100,
            'stock' => 10
        ]);
        Product::create([
            'name' => 'Product 2',
            'description' => 'Description 2',
            'price' => 200,
            'stock' => 20
        ]);
        Product::create([
            'name' => 'Product 3',
            'description' => 'Description 3',
            'price' => 300,
            'stock' => 30
        ]);
    }
}