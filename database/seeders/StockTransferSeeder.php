<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\DB;

class StockTransferSeeder extends Seeder
{
    public function run(): void
    {
        $warehouseIds = Warehouse::query()->pluck('id')->values();
        $itemIds      = InventoryItem::query()->pluck('id')->values();

        if ($warehouseIds->count() < 2 || $itemIds->isEmpty()) {
            return;
        }

        // create 20 random transfers
        for ($i = 1; $i <= 20; $i++) {
            DB::transaction(function () use ($warehouseIds, $itemIds, $i) {
                $from = $warehouseIds->random();
                $to = $warehouseIds->where(fn ($id) => $id !== $from)->values()->random();
                $itemId = $itemIds->random();

                $fromStock = Stock::query()
                    ->where('warehouse_id', $from)
                    ->where('inventory_item_id', $itemId)
                    ->lockForUpdate()
                    ->first();

                $available = $fromStock?->quantity ?? 0;
                if ($available < 1) {
                    return; // skip if no stock to transfer
                }

                $qty = random_int(1, min(50, $available));

                // decrement from
                $fromStock->update(['quantity' => $available - $qty]);

                // increment to
                $toStock = Stock::query()
                    ->where('warehouse_id', $to)
                    ->where('inventory_item_id', $itemId)
                    ->lockForUpdate()
                    ->first();

                if (!$toStock) {
                    $toStock = Stock::create([
                        'warehouse_id'      => $to,
                        'inventory_item_id' => $itemId,
                        'quantity'          => 0,
                    ]);
                }

                $toStock->update(['quantity' => $toStock->quantity + $qty]);

                // log transfer
                StockTransfer::create([
                    'from_warehouse_id' => $from,
                    'to_warehouse_id'   => $to,
                    'inventory_item_id' => $itemId,
                    'quantity'          => $qty,
                    'requested_by'      =>1,
                    'requested_at'      => now(),
                    'reference'         => "SEED-TR-".str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                ]);
            });
        }
    }
}
