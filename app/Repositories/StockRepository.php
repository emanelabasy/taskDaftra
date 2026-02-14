<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Stock;

class StockRepository extends BaseRepository
{
    public function __construct(
        protected Stock    $model
    ){
    }

    public function updateOrCreate($input)
    {
        $this->clearInventoryCache($input['warehouse_id']);

        return Stock::updateOrCreate(
            [
                'warehouse_id' => $input['warehouse_id'], 
                'inventory_item_id' => $input['inventory_item_id']
            ],
            [
                'quantity' => $input['quantity']
            ]
        );
    }

    public function getStockByWarehouseAndInventory($warehouseId,$inventoryItemId)
    {
        return  $this->model->query()
                ->where('warehouse_id', $warehouseId)
                ->where('inventory_item_id', $inventoryItemId)
                ->lockForUpdate()   //note: lock stock row to avoid race conditions
                ->first();
    }

}