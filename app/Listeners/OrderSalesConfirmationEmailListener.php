<?php

namespace App\Listeners;

use App\Data\SalesOrderData;
use App\Events\SalesOrderCreated;
use App\Mail\SalesOrderCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSalesConfirmationEmailListener
{
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
    public function handle(SalesOrderCreated $event): void
    {
        Mail::to($event->sales_order->customer->email)->queue(
            new SalesOrderCreatedMail($event->sales_order)
        );
    }
}
