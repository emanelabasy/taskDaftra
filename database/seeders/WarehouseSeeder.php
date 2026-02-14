<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::insert([
            ['name' => 'Main Warehouse',     'location' => 'cairo',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'North Warehouse',    'location' => 'Damyta',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'South Warehouse',    'location' => 'Minya',  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
