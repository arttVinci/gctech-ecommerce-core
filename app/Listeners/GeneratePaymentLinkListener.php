<?php

namespace App\Listeners;

use App\Events\SalesOrderCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Service\PaymentMethodQueryService;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneratePaymentLinkListener
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
    public function handle(SalesOrderCreatedEvent $event): void
    {
        app(PaymentMethodQueryService::class)
            ->getDriver($event->sales_order->sales_payment)
            ->process($event->sales_order);
    }
}
