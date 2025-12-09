<?php

declare(strict_types=1);

namespace App\Driver\Payment;

use App\Data\PaymentData;
use App\Models\SalesOrder;
use App\Data\SalesOrderData;
use App\Models\SalesOrderItem;
use App\Data\SalesOrderItemData;
use App\Service\SalesOrderService;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\DataCollection;
use App\Contract\PaymentDriverInterface;

class MootaPaymentDriver implements PaymentDriverInterface
{
    public readonly string $driver;

    public function __construct()
    {
        $this->driver = 'moota';
    }

    public function getMethods(): DataCollection
    {
        return PaymentData::collect([
            PaymentData::from([
                'driver'   => $this->driver,
                'method'   => 'bca-bank-transfer',
                'label'    => '( Moota )Transfer Bank Bca',
                'payload'  => [
                    'account_id'   =>   'R57WnZqpWlo'
                ]
            ])
        ], DataCollection::class);
    }

    public function process(SalesOrderData $sales_order)
    {
        $response = Http::withToken(config('services.moota.access_token'))
            ->post('https://api.moota.co/api/v2/create-transaction', [
                'order_id' => $sales_order->rtx_id,
                'bank_account_id' => data_get($sales_order->sales_payment->payload, 'account_id'),
                'customers' => [
                    'name' => $sales_order->customer->full_name,
                    'email' => $sales_order->customer->email,
                    'phone' => $sales_order->customer->no_telp
                ],
                'items' => $sales_order->items->toCollection()->map(function (SalesOrderItemData $item) {
                    return [
                        'name' => $item->name,
                        'description' => $item->deskripsi,
                        'qty' => $item->quantity,
                        'price' => $item->price
                    ];
                })->merge([
                    [
                        'name' => $sales_order->sales_shipping->kurir,
                        'description' =>  $sales_order->sales_shipping->estimated_delivery,
                        'qty' => 1,
                        'price' =>  $sales_order->shipping_cost
                    ]
                ])->toArray(),
                'description' => '',
                'note' => '',
                'redirect_url' => route('order-confirmed', $sales_order->rtx_id),
                'total' => $sales_order->total
            ]);

        return app(SalesOrderService::class)->updatePaymentPayload($sales_order, [
            'moota_payload' => $response->json('data')
        ]);
    }

    public function shouldShowPayNowButton(SalesOrderData $sales_order): bool
    {
        return true;
    }

    public function getRedirectUrl(SalesOrderData $sales_order): ?string
    {
        return data_get($sales_order->sales_payment->payload, 'moota_payload.payment_url');
    }
}
