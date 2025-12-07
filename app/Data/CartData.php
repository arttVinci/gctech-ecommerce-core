<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class CartData extends Data
{
    public float $total;
    public int $total_weight;
    public int $total_quantity;
    public string $total_price;

    public function __construct(
        #[DataCollectionOf(CartItemData::class)]
        public DataCollection $items
    ) {
        $items = $items->toCollection();
        $this->total = $items->sum(fn(CartItemData $items) => $items->price * $items->quantity);
        $this->total_weight = $items->sum(fn(CartItemData $items): int => $items->weight ?? 0);
        $this->total_quantity = $items->sum(fn(CartItemData $items): int => $items->quantity);
        $this->total_price = Number::currency($this->total);
    }
}
