<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use App\States\SalesOrder\Shipping;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ShippingReceiptNumberUpdatedEvent;

class SalesOrderService
{
    public function updateReceiptNumber(SalesOrderData $sales_order, string $receipt_number): SalesOrderData
    {
        $query = SalesOrder::where('trx_id', $sales_order->rtx_id)->first();

        $query->update([
            'shipping_receipt_number'   =>    $receipt_number
        ]);



        $data = SalesOrderData::fromModel(
            $query->refresh()
        );

        $query->status->transitionTo(Shipping::class);

        event(new ShippingReceiptNumberUpdatedEvent($data));

        return $data;
    }
}
