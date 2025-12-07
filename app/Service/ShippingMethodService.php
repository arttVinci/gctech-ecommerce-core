<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\CartData;
use App\Data\RegionData;
use App\Data\ShippingData;
use App\Data\ShippingServiceData;
use App\Driver\Shipping\APICourierShippingDriver;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;
use App\Contract\ShippingServiceInterface;
use App\Driver\Shipping\OfflineShippingDriver;

class ShippingMethodService
{
    protected array $drivers;

    public function __construct()
    {
        $this->drivers = [
            new OfflineShippingDriver(),
            new APICourierShippingDriver()
        ];
    }

    public function getDriver(ShippingServiceData $shipping_service_data): OfflineShippingDriver
    {
        return collect($this->drivers)
            ->first(fn(OfflineShippingDriver $shipping_service) => $shipping_service->getDriver() === $shipping_service_data->driver);
    }

    /**
     * @return DataCollection<ShippingServiceData>
     */
    public function getShippingService(): DataCollection
    {
        return collect($this->drivers)
            ->flatMap(fn(ShippingServiceInterface $shipping_service) => $shipping_service->getService()->toCollection())
            ->pipe(fn($items) => ShippingServiceData::collect($items, DataCollection::class));
    }

    public function getShippingMethods(
        RegionData $origin,
        RegionData $destination,
        CartData $cart,
    ): DataCollection {
        return $this->getShippingService()
            ->toCollection()
            ->map(function (ShippingServiceData $shipping_service_data) use ($origin, $destination, $cart) {
                $shipping_data = $this->getDriver($shipping_service_data)
                    ->getRate($origin, $destination, $cart, $shipping_service_data);

                if ($shipping_data == null) {
                    return;
                }

                Cache::put(
                    "shipping_hash{$shipping_data->hash}",
                    $shipping_data,
                    now()->addMinutes(15)

                );

                return $shipping_data;
            })
            ->reject(fn($item) => $item === null)
            /** @var Collection<ShippingData> $items */
            ->pipe(fn($items) => ShippingData::collect($items, DataCollection::class));
    }

    public function getShippingMethod(String $hash): ?ShippingData
    {
        return Cache::get("shipping_hash{$hash}");
    }
}
