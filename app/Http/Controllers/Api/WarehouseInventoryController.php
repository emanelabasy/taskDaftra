<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\WarehouseInventorySearchRequest;
use App\Services\WarehouseInventoryService;
use App\Http\Resources\WarehouseInventoryResource;
use App\Models\Warehouse;

class WarehouseInventoryController extends Controller
{
    public function __construct(
        protected WarehouseInventoryService  $warehouseInventoryService   
    ){

    }

    public function index(WarehouseInventorySearchRequest $request)
    {
        return WarehouseInventoryResource::collection(
            $this->warehouseInventoryService->list($request->validated())
        );
    }

    public function show(Request $request, Warehouse $warehouse)
    {
        $inventory = $this->warehouseInventoryService->show($warehouse);

        //todo:improve --> return by Resources
        return response()->json([
            'warehouse' => [
                'id'       => $warehouse->id,
                'name'     => $warehouse->name,
                'location' => $warehouse->location,
            ],
            'inventory' => $inventory,
        ], 200);
    }

}
