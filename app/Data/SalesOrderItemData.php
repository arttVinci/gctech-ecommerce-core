<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\Computed;

class SalesOrderItemData extends Data
{
    #[Computed]
    public string $price_formatted;
    #[Computed]
    public string $total_formatted;

    public function __construct(
        public string $name,
        public string $tags,
        public string $sku,
        public string $slug,
        public Optional|null|string $deskripsi,
        public int $quantity,
        public float $price,
        public int $weight,
        public string $media_url,
        public float $total,
    ) {
        $this->price_formatted = Number::currency($price);
        $this->total_formatted = Number::currency($total);
    }
}
