<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'name' => '10% Discount',
            'percentage' => 10,
            'active' => 1
        ]);
        Discount::create([
            'name' => '20% Discount',
            'percentage' => 20,
            'active' => 1
        ]);
    }
}
