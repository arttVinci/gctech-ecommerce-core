<?php

declare(strict_types=1);

namespace App\States\SalesOrder\Transitions;

use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use Spatie\ModelStates\Transition;
use App\States\SalesOrder\Shipping;
use App\Events\ShippingReceiptNumberUpdatedEvent;

class ProgressToShipping extends Transition
{
    public function __construct(public SalesOrder $sales_order) {}

    public function handle()
    {
        $this->sales_order->update([
            'status'   =>   Shipping::class
        ]);

        event(new ShippingReceiptNumberUpdatedEvent(
            SalesOrderData::fromModel($this->sales_order)
        ));

        return $this->sales_order;
    }
}
