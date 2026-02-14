<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = Warehouse::query()->pluck('id');
        $items      = InventoryItem::query()->pluck('id');

        foreach ($warehouses as $warehouseId) {
            foreach ($items as $itemId) {
                Stock::updateOrCreate(
                    ['warehouse_id' => $warehouseId, 'inventory_item_id' => $itemId],
                    ['quantity' => random_int(0, 200)]
                );
            }
        }
    }
}
