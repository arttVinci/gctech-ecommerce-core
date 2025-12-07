<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\RegionData;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelData\Attributes\Computed;

class ShippingData extends Data
{
    #[Computed]
    public string $label;
    #[Computed]
    public string $formatted_cost;
    #[Computed]
    public string $hash;

    public function __construct(
        public string $driver,
        public string $kurir,
        public string $service,
        public string $estimated_delivery,
        public float $cost,
        public int $weight,
        public RegionData $origin,
        public RegionData $destination,
        public string|null $logo_url
    ) {
        $this->formatted_cost = Number::currency($cost);

        $kurir_label = ucfirst($kurir);

        $this->label = "$kurir_label ( $estimated_delivery )";

        $this->hash = md5("$origin->code-$destination->code-$driver-$kurir-$service-$estimated_delivery-$cost");
    }
}
