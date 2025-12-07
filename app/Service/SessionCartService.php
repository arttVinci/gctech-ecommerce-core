<?php

declare(strict_types=1);

namespace App\Service;

use App\Data\CartData;
use App\Data\CartItemData;
use App\Contract\CartServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Spatie\LaravelData\DataCollection;

class SessionCartService implements CartServiceInterface
{
    protected string $session_key = 'cart';

    protected function load(): DataCollection
    {
        $raw = Session::get($this->session_key, []);

        $filtered = collect($raw)
            ->filter(fn($item) => !is_null($item)) // Pengaman tambahan
            ->values()
            ->all();


        return new DataCollection(CartItemData::class, $filtered);
    }

    /** @param Collection<int, CartItemData> $items */
    protected function save(Collection $items)
    {
        Session::put($this->session_key, $items->values()->all());
    }

    public function addOrUpdate(CartItemData $items): void
    {
        $collection = $this->load()->toCollection();
        $updated = false;

        $cart = $collection->map(function (CartItemData $i) use ($items, &$updated) {
            if ($i->sku == $items->sku) {
                $updated = true;
                return $items; // ganti item lama dengan item baru
            }
            return $i; // kembalikan item lama jika SKU beda
        })->values()->collect();

        if (!$updated) {
            $cart->push($items);
        }

        $this->save($cart);
    }

    public function getItemBySku(string $sku): ?CartItemData
    {
        return $this->load()->toCollection()->first(fn(CartItemData $i) => $i->sku == $sku);
    }

    public function remove(string $sku): void
    {
        $cart = $this->load()->toCollection()
            ->reject(fn(CartItemData $i) => $i->sku === $sku)
            ->values()
            ->collect();

        $this->save($cart);
    }

    public function clear(): void
    {
        Session::forget($this->session_key);
    }

    public function all(): CartData
    {
        return new CartData($this->load());
    }
}
