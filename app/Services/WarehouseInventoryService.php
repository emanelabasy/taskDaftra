<?php
namespace App\Services;

use App\Repositories\WarehouseInventoryRepository;
use Illuminate\Support\Facades\Cache;

class WarehouseInventoryService
{
    public function __construct(
        protected WarehouseInventoryRepository  $warehouseInventoryRepository   
    ){
    }

    public function list($filters)
    {
        return $this->warehouseInventoryRepository->list($filters);
    }

    public function show($warehouse)
    {
        $key = $this->warehouseInventoryRepository->inventoryCacheKey($warehouse->id);
        return Cache::remember($key, now()->addMinutes(5), function () use ($warehouse) {
            return $this->warehouseInventoryRepository->show($warehouse);
        });
    }

    public function adjustStock($input)
    {
        return $this->warehouseInventoryRepository->updateOrCreate($input);
    }
}