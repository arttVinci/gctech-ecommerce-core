<?php

declare(strict_types=1);

namespace App\Driver\Shipping;

use App\Data\CartData;
use App\Data\RegionData;
use App\Data\ShippingData;
use App\Data\ShippingServiceData;
use Spatie\LaravelData\DataCollection;
use App\Contract\ShippingServiceInterface;

class OfflineShippingDriver implements ShippingServiceInterface
{
    public readonly string $driver;

    public function __construct()
    {
        $this->driver = 'offline';
    }

    public function getDriver(): string
    {
        return $this->driver;
    }
    /** @return DataCollection<ShippingServiceData> */
    public function getService(): DataCollection
    {
        return ShippingServiceData::collect([
            [
                'driver' => $this->driver,
                'code'   => 'offline-flat-15',
                'kurir'  => 'Internal Kurir',
                'service' => 'Instant'
            ],
            [
                'driver' => $this->driver,
                'code'   => 'offline-flat-20',
                'kurir'  => 'Internal Kurir',
                'service' => 'Same Day'
            ]
        ], DataCollection::class);
    }

    public function getRate(
        RegionData $origin,
        RegionData $destination,
        CartData $cart,
        ShippingServiceData $shipping_service
    ): ?ShippingData {
        $data = null;

        switch ($shipping_service->code) {
            case 'offline-flat-15':
                $data = ShippingData::from([
                    'driver' => $this->driver,
                    'kurir'  => $shipping_service->kurir,
                    'service' => $shipping_service->service,
                    'estimated_delivery' => '1-2 Hari',
                    'cost' => 15000,
                    'weight' => $cart->total_weight,
                    'origin' => $origin,
                    'destination' => $destination,
                ]);
                break;

            case 'offline-flat-20':
                $data = ShippingData::from([
                    'driver' => $this->driver,
                    'kurir'  => $shipping_service->kurir,
                    'service' => $shipping_service->service,
                    'estimated_delivery' => '1 Hari',
                    'cost' => 21000,
                    'weight' => $cart->total_weight,
                    'origin' => $origin,
                    'destination' => $destination,
                ]);
                break;
        };

        return $data;
    }
}
