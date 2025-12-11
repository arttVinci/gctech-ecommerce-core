<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Product;
use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use App\Data\SalesOrderItemData;
use App\States\SalesOrder\Pending;
use Illuminate\Support\Facades\DB;
use App\States\SalesOrder\Progress;
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

    public function updatePaymentPayload(SalesOrderData $sales_order, array $payload): SalesOrderData
    {
        SalesOrder::where('trx_id', $sales_order->rtx_id)
            ->update([
                'payment_payload' => array_merge($sales_order->sales_payment->payload, $payload)
            ]);

        return SalesOrderData::from(
            SalesOrder::where('trx_id', $sales_order->rtx_id)->first()
        );
    }

    public function returnStock(SalesOrderData $sales_order): void
    {
        $sales_order->items->toCollection()->each(function (SalesOrderItemData $item) {
            DB::transaction(function () use ($item) {
                Product::lockForUpdate()->update([
                    'stock'   =>   $item->quantity
                ]);
            });
        });
    }

    public function approvePaymentUsingTrxID(
        string $trx_id,
        float $total
    ): void {
        $sales_order = SalesOrder::query()
            ->where('trx_id', $trx_id)
            ->where('total', $total)
            ->where('status', Pending::class)
            ->first();

        $sales_order->status->transitionTo(Progress::class);
    }
}
