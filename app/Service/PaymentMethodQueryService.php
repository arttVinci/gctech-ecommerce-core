<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\PaymentData;
use App\Data\SalesPaymentData;
use App\Data\SalesOrderData;
use Spatie\LaravelData\DataCollection;
use App\Contract\PaymentDriverInterface;
use App\Driver\Payment\OfflinePaymentDriver;

class PaymentMethodQueryService
{
    protected array $driver = [];

    public function __construct()
    {
        $this->driver = [new OfflinePaymentDriver()];
    }

    public function getDriver(PaymentData|SalesPaymentData $paymentData): PaymentDriverInterface
    {
        return collect($this->driver)->first(fn(OfflinePaymentDriver $paymentDriverInterface) => $paymentDriverInterface->driver === $paymentData->driver);
    }

    public function getPaymentMethods(): DataCollection
    {
        return collect($this->driver)
            ->flatMap(fn(PaymentDriverInterface $paymentDriverInterface) => $paymentDriverInterface->getMethods()->toCollection())
            ->pipe(fn($items) => PaymentData::collect($items, DataCollection::class));
    }

    public function getPaymentMethodHash(string $hash): PaymentData
    {
        return $this->getPaymentMethods()
            ->toCollection()
            ->first(fn(PaymentData $paymentData) => $paymentData->hash === $hash);
    }

    public function shouldShowButton(SalesOrderData $sales_order): bool
    {
        return $this->getDriver($sales_order->sales_payment)->shouldShowPayNowButton($sales_order);
    }

    public function getRedirectUrl(SalesOrderData $sales_order)
    {
        return $this->getDriver($sales_order->sales_payment)->getRedirectUrl($sales_order);
    }
}
