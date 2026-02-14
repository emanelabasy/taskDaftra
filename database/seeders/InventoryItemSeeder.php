<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;

class InventoryItemSeeder extends Seeder
{
    public function run(): void
    {
        InventoryItem::insert([
            ['name' => 'Engine Oil 5W-30', 'sku' => 'OIL-5W30', 'description' => 'Synthetic engine oil', 'price'=>100 ,'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brake Pads',       'sku' => 'BRK-PAD',  'description' => 'Front brake pads',     'price'=>100 ,'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Air Filter',       'sku' => 'AIR-FLT',  'description' => 'Standard air filter',  'price'=>100 ,'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tire 205/55R16',   'sku' => 'TIRE-205', 'description' => 'All-season tire',      'price'=>100 ,'unit' => 'kg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
