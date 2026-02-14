<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Events\LowStockDetected;
use App\Listeners\NotifyAdminLowStock;
use App\Repositories\StockTransferRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Events\CallQueuedListener;

class LowStockEventQueuedTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_listener_is_queued(): void
    {
        Config::set('inventory.low_stock_threshold', 15);

        $from = Warehouse::factory()->create();
        $to   = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id' => $from->id,
            'inventory_item_id' => $item->id,
            'quantity' => 20,
        ]);

        Queue::fake();

        app(StockTransferRepository::class)->transfer([
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 6,
            'reference' => 'EV-0002',
        ]);

        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class === NotifyAdminLowStock::class
                && $job->method === 'handle';
        });
    }

    public function test_low_stock_event_is_dispatched(): void
    {
        Config::set('inventory.low_stock_threshold', 15);

        $from = Warehouse::factory()->create();
        $to   = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id' => $from->id,
            'inventory_item_id' => $item->id,
            'quantity' => 20,
        ]);

        Event::fake([LowStockDetected::class]);

        app(StockTransferRepository::class)->transfer([
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 6, // remaining 14 < 15
            'reference' => 'EV-0001',
        ]);

        Event::assertDispatched(LowStockDetected::class, function (LowStockDetected $e) use ($from, $item) {
            return $e->warehouseId === $from->id
                && $e->inventoryItemId === $item->id
                && $e->currentQty === 14
                && $e->threshold === 15;
        });
    }

}
