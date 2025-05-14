<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'name' => 'Client 1',
            'email' => 'client1@example.com',
            'phone' => '123456789',
            'address' => '123 Main St'
        ]);
        Client::create([
            'name' => 'Client 2',
            'email' => 'client2@example.com',
            'phone' => '987654321',
            'address' => '321 Main St'
        ]);
    }
}
