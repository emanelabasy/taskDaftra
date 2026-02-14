<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','sku','description','unit','price'];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(StockTransfer::class);
    }

    public function scopeSearch(Builder $query, array $filters): Builder
    {
        return $query
            ->when(!empty($filters['search_word']), function (Builder $q) use ($filters) {
                $search = $filters['search_word'];
                $q->where(function (Builder $sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "{$search}%");
                });
            })
            ->when(isset($filters['min_price']) && $filters['min_price'] !== '', function (Builder $q) use ($filters) {
                $q->where('price', '>=', (float)$filters['min_price']);
            })
            ->when(isset($filters['max_price']) && $filters['max_price'] !== '', function (Builder $q) use ($filters) {
                $q->where('price', '<=', (float)$filters['max_price']);
            });
    }
    
}

