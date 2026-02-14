<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryItemSearchRequest;
use App\Http\Resources\InventoryItemResource;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService  $inventoryService   
    ){

    }

    public function index(InventoryItemSearchRequest $request)
    {
        return InventoryItemResource::collection(
            $this->inventoryService->list($request->validated())
        );
    }

}