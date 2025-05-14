<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sale::create([
            'client_id' => 1,
            'date' => '2023-07-01',
            'total' => 0,
            'discount_id' => 1,
            'subtotal' => 0
        ]);
        Sale::create([
            'client_id' => 2,
            'date' => '2023-07-02',
            'total' => 0,
            'discount_id' => 2,
            'subtotal' => 0
        ]);
    }
}
