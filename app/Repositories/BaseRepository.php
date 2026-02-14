<?php
namespace App\Repositories;
use Illuminate\Support\Facades\Cache;

class BaseRepository
{

    public function inventoryCacheKey(int $warehouseId): string
    {
        return "warehouse:{$warehouseId}:inventory";
    }

    public function clearInventoryCache(int $warehouseId): void
    {
        //todo:improve --> move cache to Observers
        Cache::forget($this->inventoryCacheKey($warehouseId));
    }

}