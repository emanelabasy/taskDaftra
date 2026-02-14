<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockTransferStoreRequest;
use App\Http\Requests\StockTransferSearchRequest;
use App\Http\Resources\StockTransferResource;
use App\Services\StockTransferService;
use App\Models\StockTransfer;

class StockTransferController extends Controller
{
    public function __construct(
        protected StockTransferService  $stockTransferService   
    ){

    }

    public function index(StockTransferSearchRequest $request)
    {
        return StockTransferResource::collection(
            $this->stockTransferService->list($request->validated())
        );
    }

    public function show(StockTransfer $stockTransfer)
    {
        //todo:improve --> return by Resources
        return response()->json([
            'data' => $stockTransfer->load(['fromWarehouse','toWarehouse','item']),
        ], 200);
    }

    public function store(StockTransferStoreRequest $request)
    {
        $transfer = $this->stockTransferService->transfer($request->validated());

        //todo:improve --> return by Resources
        return response()->json([
            'message' => 'Stock transferred successfully.',
            'data'    => $transfer->load(['fromWarehouse','toWarehouse','item']),
        ], 201);
    }

}
