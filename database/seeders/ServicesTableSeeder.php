<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => 'Air Conditioning', 'price' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Repair/service', 'price' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carpentry', 'price' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Concrete', 'price' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drywall', 'price' => 65, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Painting', 'price' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electrical', 'price' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Plumbing', 'price' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Remodeling', 'price' => 65, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Roofing', 'price' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Repair', 'price' => 65, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Handyman', 'price' => 45, 'created_at' => now(), 'updated_at' => now()],
            // Add more rows as needed
        ]);
    }
}
