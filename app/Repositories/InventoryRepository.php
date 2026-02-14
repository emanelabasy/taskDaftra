<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use App\Traits\ValidPaginationLimit;
use App\Models\InventoryItem;

class InventoryRepository extends BaseRepository
{
    use ValidPaginationLimit;

    public function __construct(
        protected InventoryItem   $model
    ){
    }

    public function query($filters)
    {
        return $this->model->query()
            ->select(['id', 'name', 'sku', 'price', 'unit'])
            ->search($filters);
    }

    public function list($filters)
    {
        return $this->query($filters)
                ->orderBy($filters['sort']??'id', $filters['direction']??'DESC')
                ->cursorPaginate(perPage: $this->paginationLimit($filters['limit']))
                ->withQueryString();
    }

}