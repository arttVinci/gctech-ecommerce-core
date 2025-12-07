<?php

namespace App\Data;

use App\Models\Region;
use Spatie\LaravelData\Data;

class RegionData extends Data
{
    public string $label;

    public function __construct(
        public string $code,
        public string $province,
        public string $city,
        public string $district,
        public string $sub_district,
        public string $postal_code,
        public string $country = 'Indonesia'
    ) {
        $this->label = "$sub_district, $district, $city, $province, $postal_code";
    }

    public static function fromModel(Region $region): self
    {
        return new self(
            $region->code,
            $region->parent->parent->parent->name,
            $region->parent->parent->name,
            $region->parent->name,
            $region->name,
            $region->postal_code,
        );
    }
}
