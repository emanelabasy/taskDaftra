<?php
namespace App\Repositories;

use App\Events\LowStockDetected;
use App\Models\StockTransfer;
use App\Traits\ValidPaginationLimit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransferRepository extends BaseRepository
{
    use ValidPaginationLimit;

    public function __construct(
        protected StockTransfer    $model,
        protected StockRepository  $stockRepository
    ){
    }


    public function query($filters)
    {
        return $this->model->query()
            ->with([
                'fromWarehouse:id,name,location',
                'toWarehouse:id,name,location',
                'item:id,name,sku',
                'requestedBy:id,name'
            ])
            ->when(!empty($filters['from_warehouse_id']), function (Builder $q) use ($filters) {
                $q->where('from_warehouse_id', $filters['from_warehouse_id']);
            })
            ->when(!empty($filters['to_warehouse_id']), function (Builder $q) use ($filters) {
                $q->where('to_warehouse_id', $filters['to_warehouse_id']);
            })
            ->when(!empty($filters['inventory_item_id']), function (Builder $q) use ($filters) {
                $q->where('inventory_item_id', $filters['inventory_item_id']);
            });
    }

    public function list($filters)
    {
        return $this->query($filters)
                ->orderBy('id', 'DESC')
                ->cursorPaginate(perPage: $this->paginationLimit($filters['limit']))
                ->withQueryString();
    }

    public function create($input)
    {
        return $this->model->create($input);
    }

    public function transfer(array $input): StockTransfer
    {
        return DB::transaction(function () use ($input) {

            // 1- get from source and decrement if quantity > required quantity
            $fromStock = $this->getFromSourceStock($input);

            // 2- add to destination and increment if quantity valid
            $toStock = $this->MoveToDestinationStock($input);

            //3- saving in StockTransfer table
            $transfer = $this->create($input);

            //4- clear Cache
            $this->clearInventoryCache($input['from_warehouse_id']);
            $this->clearInventoryCache($input['to_warehouse_id']);

            //5- send event  with "LowStockDetected"
            $this->sendEvent($input,$fromStock);

            return $transfer;
        });
    }

    private function getFromSourceStock($input)
    {
        $fromStock = $this->stockRepository->getStockByWarehouseAndInventory($input['from_warehouse_id'],$input['inventory_item_id']);
        $available = $fromStock?->quantity ?? 0;

        if ($available < $input['quantity']) {
            throw ValidationException::withMessages([
                'quantity' => ['Quantity not available in source warehouse.'],
            ]);
        }
        //decrement
        $fromStock->update([
            'quantity' => $available - $input['quantity'],
        ]);
        return $fromStock->refresh();
    }

    private function MoveToDestinationStock($input)
    {
        $toStock = $this->stockRepository->getStockByWarehouseAndInventory($input['to_warehouse_id'],$input['inventory_item_id']);
        if (!$toStock) {
            $toStock = $this->stockRepository->updateOrCreate([
                'warehouse_id'      => $input['to_warehouse_id'],
                'inventory_item_id' => $input['inventory_item_id'],
                'quantity'          => 0,
            ]);
        }

        // increment
        $toStock->update([
            'quantity' => $toStock->quantity + $input['quantity'],
        ]);
        
        return $toStock;
    }

    private function sendEvent($input,$fromStock)
    {
        $threshold = (int) config('inventory.low_stock_threshold');
        $qty = (int) ($fromStock->quantity ?? 0);

        if ($qty < $threshold) {
            event(new LowStockDetected(
                warehouseId    : (int) $input['from_warehouse_id'],
                inventoryItemId: (int) $input['inventory_item_id'],
                currentQty     : $qty,
                threshold      : (int) $threshold
            ));
        }   

    }

}
