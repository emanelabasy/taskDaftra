<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdjustStockRequest;
use App\Services\StockService;

class StockController extends Controller
{
    public function __construct(
        protected StockService  $stockService   
    ){

    }

    public function adjustStock(AdjustStockRequest $request)
    {
        $stock = $this->stockService->adjustStock($request->validated());

        //todo:improve --> return by Resources
        return response()->json([
            'message' => 'Stock updated.',
            'data'    => $stock->load('warehouse','item'),
        ], 200);
    }

}
