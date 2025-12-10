<?php

declare(strict_types=1);

namespace App\Driver\Shipping;

use App\Data\CartData;
use App\Data\RegionData;
use App\Data\ShippingData;
use App\Data\ShippingServiceData;
use App\States\SalesOrder\Shipping;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;
use App\Contract\ShippingServiceInterface;
use Illuminate\Http\Client\ConnectionException;

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
                'kurir' => 'JNE',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jne-express',
                'kurir' => 'JNE',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jne-cargo',
                'kurir' => 'JNE',
                'service' => 'Cargo',
            ],

            // // --- J&T Express ---
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-reguler',
                'kurir' => 'J&T Express',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-express',
                'kurir' => 'J&T Express',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'jnt-cargo',
                'kurir' => 'J&T Express',
                'service' => 'Cargo',
            ],

            // // --- Grab ---
            [
                'driver'  => $this->driver,
                'code'    => 'grab-instant',
                'kurir' => 'Grab',
                'service' => 'Instant',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'grab-same-day',
                'kurir' => 'Grab',
                'service' => 'Same Day',
            ],

            // // --- SiCepat ---
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-reguler',
                'kurir' => 'SiCepat',
                'service' => 'Regular',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-express',
                'kurir' => 'SiCepat',
                'service' => 'Express',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-cargo',
                'kurir' => 'SiCepat',
                'service' => 'Cargo',
            ],
            [
                'driver'  => $this->driver,
                'code'    => 'sicepat-same-day',
                'kurir' => 'SiCepat',
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
        try {
            Log::info("Memulai request API");

            $response = Http::timeout(15)
                ->withoutVerifying()
                ->withBasicAuth(
                    config('shipping.api_kurir.username'),
                    config('shipping.api_kurir.password')
                )->post('https://sandbox.apikurir.id/shipments/v1/open-api/rates', [
                    "isUseInsurance" => true,
                    "isPickup" => true,
                    "isCod" => false,
                    "dimensions" => [10, 10, 10],
                    "weight" => $cart->total_weight,
                    "packagePrice" => $cart->total,
                    "origin" => [
                        "postalCode" => $origin->postal_code,
                    ],
                    "destination" => [
                        "postalCode" => $destination->postal_code,
                    ],
                    "logistics" => [$shipping_service->kurir],
                    "services" => [$shipping_service->service]
                ]);
        } catch (ConnectionException $e) {
            Log::error("API Timeout/Connection" . $e->getMessage());
            return null;
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error("API Request Error" . $e->getMessage());

            return null;
        } catch (\Exception $e) {
            Log::error("General Error" . $e->getMessage());

            return null;
        }

        $data = $response->collect('data')->flatten(1)->values()->first();
        if (empty($data)) {
            Log::warning("Data kosong dari API untuk {$shipping_service->kurir}");
            return null;
        }

        Log::info("Berhasil mendapatkan rate untuk {$shipping_service->kurir} - {$shipping_service->service}");

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
