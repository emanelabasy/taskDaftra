<?php

namespace App\Traits;

trait ValidPaginationLimit
{

    public function paginationLimit($limit = 15): int
    {
        if ($limit < 0 || $limit > config('api.max_pagination_limit')) {
            return min((int)15, config('api.max_pagination_limit')) ;
        }
        return min((int)$limit, config('api.max_pagination_limit')) ;
    }

}