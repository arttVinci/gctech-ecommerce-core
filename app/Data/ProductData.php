<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\Product;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Computed;

class ProductData extends Data
{
    #[Computed]
    public string $price_formated;
    public function __construct(
        public string $name,
        public string $tags,
        public string $sku,
        public string $slug,
        public Optional|null|string $deskripsi,
        public int $stock,
        public float $price,
        public int $weight,
        public string $media_url,
        public Optional|array $gallery = new Optional()
    ) {
        $this->price_formated = Number::currency($price);
    }

    public static function fromModel(Product $product, bool $with_gallery = false): self
    {
        return new self(
            $product->name,
            $product->tags()->where('type', 'collection')->pluck('name')->implode(', '),
            $product->sku,
            $product->slug,
            $product->deskripsi,
            $product->stock,
            floatVal($product->price),
            $product->weight,
            $product->getFirstMediaUrl('cover'),
            $with_gallery ? $product->getMedia('galery')->map(fn($record) => $record->getUrl())->toArray() : new Optional()

        );
    }
}
