<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enum\StockStatusEnum;

class StockTransfer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'inventory_item_id',
        'from_warehouse_id',
        'to_warehouse_id',
        'quantity',
        'status',
        'reference',
        'note',
        'requested_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'status'       => StockStatusEnum::class,
        'requested_at' => 'datetime',
        'approved_at'  => 'datetime',
        'completed_at' => 'datetime',
        'rejected_at'  => 'datetime',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
      
    
}
