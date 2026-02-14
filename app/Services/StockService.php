<?php
namespace App\Services;

use App\Repositories\StockRepository;

class StockService
{
    public function __construct(
        protected StockRepository  $stockRepository   
    ){
    }

    public function adjustStock($input)
    {
        return $this->stockRepository->updateOrCreate($input);
    }
}