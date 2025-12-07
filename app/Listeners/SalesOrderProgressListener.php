<?php

namespace App\Listeners;

use App\Mail\SalesOrderProgressMail;
use Illuminate\Support\Facades\Mail;
use App\Events\SalesOrderProgressEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesOrderProgressListener
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
    public function handle(SalesOrderProgressEvent $event): void
    {
        Mail::to($event->sales_order->customer->email)->queue(
            new SalesOrderProgressMail($event->sales_order)
        );
    }
}
