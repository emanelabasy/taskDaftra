<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class StockTransferFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_transfer_returns_201_and_updates_stocks(): void
    {
        $user = User::factory()->create();

        // add middleware: abilities:transfers:create
        Sanctum::actingAs($user, ['transfers:create']);

        $from = Warehouse::factory()->create();
        $to   = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::create([
            'warehouse_id' => $from->id,
            'inventory_item_id' => $item->id,
            'quantity' => 20,
        ]);

        $payload = [
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
            'reference' => 'FT-0001',
        ];

        $res = $this->postJson('/api/stock-transfers', $payload);

        $res->assertStatus(201)
            ->assertJsonPath('message', 'Stock transferred successfully.');

        $this->assertDatabaseHas('stock_transfers', [
            'from_warehouse_id' => $from->id,
            'to_warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $from->id,
            'inventory_item_id' => $item->id,
            'quantity' => 15,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $to->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);
    }
}
