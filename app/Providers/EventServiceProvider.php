<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LowStockDetected;
use App\Listeners\NotifyAdminLowStock;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LowStockDetected::class => [
            NotifyAdminLowStock::class,
        ],
    ];
}
