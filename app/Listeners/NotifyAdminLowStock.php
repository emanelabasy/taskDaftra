<?php

namespace App\Listeners;

use App\Events\LowStockDetected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyAdminLowStock implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LowStockDetected $event): void
    {
        // log action
        Log::warning('Low stock detected', [
            'warehouse_id' => $event->warehouseId,
            'item_id'      => $event->inventoryItemId,
            'current_qty'  => $event->currentQty,
            'threshold'    => $event->threshold,
        ]);

        // todo: send email
        // Mail::to(admin_email)->send(new LowStockMail(...));
    }
}
