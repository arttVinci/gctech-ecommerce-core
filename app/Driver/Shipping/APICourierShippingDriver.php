<?php

declare(strict_types=1);

namespace App\Driver\Shipping;

use App\Data\CartData;
use App\Data\RegionData;
use App\Data\ShippingData;
use App\Data\ShippingServiceData;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\DataCollection;
use App\Contract\ShippingServiceInterface;
use App\States\SalesOrder\Shipping;

class APICourierShippingDriver implements ShippingServiceInterface
{
    public readonly string $driver;

    public function __construct()
    {
        $this->driver = 'apikurir';
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    /** @return DataCollection<ShippingServiceData> */
    public function getService(): DataCollection
    {
        return ShippingServiceData::collect([
            // --- JNE ---
            [
                'driver'  => $this->driver,
                'code'    => 'jne-reguler',
                'courier' => 'JNE',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jne-express', // YES (Yakin Esok Sampai)
                'courier' => 'JNE',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jne-cargo', // JTR (Trucking)
                'courier' => 'JNE',
                'service' => 'Cargo',
            ],

            // --- J&T Express ---
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-reguler', // EZ
                'courier' => 'J&T Express',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-express',
                'courier' => 'J&T Express',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-cargo', // ECO
                'courier' => 'J&T Express',
                'service' => 'Cargo',
            ],

            // --- Grab ---
            [
                'driver'  => $this->driver,
                'code'    => 'grab-instant',
                'courier' => 'Grab',
                'service' => 'Instant',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'grab-same-day',
                'courier' => 'Grab',
                'service' => 'Same Day',
            ],

            // --- SiCepat ---
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-reguler', // SIUNTUNG
                'courier' => 'SiCepat',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-express', // BEST
                'courier' => 'SiCepat',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-cargo', // GOKIL
                'courier' => 'SiCepat',
                'service' => 'Cargo',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-same-day', // SAMEDAY
                'courier' => 'SiCepat',
                'service' => 'Same Day',
            ],
        ], DataCollection::class);
    }

    public function getRate(
        RegionData $origin,
        RegionData $destination,
        CartData $cart,
        ShippingServiceData $shipping_service
    ): ?ShippingData {
        $response = Http::withBasicAuth(
            config('shipping.api_kurir.username'),
            config('shipping.api_kurir.password')
        )->post('https://sandbox.apikurir.id/shipments/v1/open-api/rates', [
            'isUseInsurance' => true,
            'isPickup' => true,
            'isCod' => false,
            'weight' => $cart->total_weight,
            'packagePrice' => $cart->total,
            'origin' => [
                'postalCode' => $origin->postal_code
            ],
            'destination' => [
                'postalCode' => $destination->postal_code
            ],
            'logistics' => [$shipping_service->kurir],
            'services' => [$shipping_service->service]
        ]);

        $data = $response->collect('data')->flatten(1)->values()->first();
        if (empty($data)) {
            return null;
        }

        $est = data_get($data, 'minDuration') . '-' . data_get($data, 'maxDuration') . ' ' . data_get($data, 'durationType');
        return new ShippingData(
            $this->driver,
            $shipping_service->kurir,
            $shipping_service->service,
            $est,
            data_get($data, 'price'),
            data_get($data, 'weight'),
            $origin,
            $destination,
            data_get($data, 'logoUrl')
        );
    }
}
