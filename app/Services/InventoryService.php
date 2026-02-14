<?php
namespace App\Services;

use App\Repositories\InventoryRepository;

class InventoryService
{
    public function __construct(
        protected InventoryRepository  $inventoryRepository   
    ){
    }

    public function list($filters)
    {
        return $this->inventoryRepository->list($filters);
    }

}