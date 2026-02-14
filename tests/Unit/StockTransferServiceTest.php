<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Services\StockTransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class StockTransferServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_over_transfer_throws_validation_exception(): void
    {
        $from = Warehouse::factory()->create();
        $to   = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id' => $from->id,
            'inventory_item_id' => $item->id,
            'quantity' => 3,
        ]);

        $service = app(StockTransferService::class);

        $this->expectException(ValidationException::class);

        $service->transfer([
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 10, 
            'reference' => 'UT-0001',
        ]);
    }
}
