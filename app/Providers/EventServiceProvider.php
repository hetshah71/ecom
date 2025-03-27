<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\UserRegistered;

use App\Events\OrderPlaced;
use App\Listeners\SendOrderPlacedEmail;
use App\Events\InvoiceGenerated;
use App\Listeners\SendInvoiceEmail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        OrderPlaced::class => [SendOrderPlacedEmail::class],
        InvoiceGenerated::class => [SendInvoiceEmail::class],
    ];

    public function boot()
    {
        parent::boot();
    }
}
