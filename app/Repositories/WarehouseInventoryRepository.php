<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\ValidPaginationLimit;
use App\Models\Stock;

class WarehouseInventoryRepository extends BaseRepository
{
    use ValidPaginationLimit;

    public function __construct(
        protected Stock    $model
    ){
    }

    public function query($filters)
    {
        return $this->model->query()
            ->with([
                'warehouse:id,name,location',
                'item:id,name,sku'
            ])
            ->when(!empty($filters['search_word']), function (Builder $q) use ($filters) {
                $search = $filters['search_word'];
                $q->whereHas('item', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when(!empty($filters['warehouse_id']), function (Builder $q) use ($filters) {
                $q->where('warehouse_id', $filters['warehouse_id']);
            })
            ->when(!empty($filters['item_id']), function (Builder $q) use ($filters) {
                $q->where('inventory_item_id', $filters['item_id']);
            })
            ->when(!empty($filters['sku']), function (Builder $q) use ($filters) {
                $q->whereHas('item', fn ($q) => $q->where('sku', $filters['sku']));
            })

            ->when(!empty($filters['min_qty']), function (Builder $q) use ($filters) {
                $q->where('quantity', '>=', $filters['min_qty']);
            })
            ->when(!empty($filters['max_qty']), function (Builder $q) use ($filters) {
                $q->where('quantity', '>=', $filters['max_qty']);
            })
            ->when(!empty($filters['low_stock']), function (Builder $q) use ($filters) {
                $q->where('quantity', '<', config('inventory.low_stock_threshold'));
            });
    }

    public function list($filters)
    {
        return $this->query($filters)
                ->orderBy('warehouse_id')->orderByDesc('quantity')
                ->cursorPaginate(perPage: $this->paginationLimit($filters['limit']))
                ->withQueryString();
    }

    public function show($warehouse)
    {
        return $warehouse->stocks()
            ->with('item:id,name,sku')
            ->orderByDesc('quantity')
            ->get()
            ->map(fn ($s) => [
                'item_id' => $s->inventory_item_id,
                'name'    => $s->item->name,
                'sku'     => $s->item->sku,
                'quantity'=> (int) $s->quantity,
            ]);
    }

}