<?php
namespace App\Services;

use App\Repositories\StockTransferRepository;

class StockTransferService
{
    public function __construct(
        protected StockTransferRepository  $stockTransferRepository   
    ){
    }

    public function list($filters)
    {
        return $this->stockTransferRepository->list($filters);
    }

    public function transfer(array $input)
    {
        return $this->stockTransferRepository->transfer($input);
    }

}
