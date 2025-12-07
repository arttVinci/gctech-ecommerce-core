<?php

namespace App\Livewire;

use App\Contract\CartServiceInterface;
use App\Data\CartItemData;
use App\Data\ProductData;
use Livewire\Component;

class AddToCart extends Component
{
    public int $quantity = 1;
    public string $sku;
    public float $price;
    public int $stock;
    public int $weight;

    public string $label = 'Add To Cart';

    protected function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1', "max:{$this->stock}"]
        ];
    }

    public function mount(ProductData $product, CartServiceInterface $cart)
    {
        $this->sku = $product->sku;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->weight = $product->weight;
        $this->quantity = $cart->getItemBySku($product->sku)->quantity ?? 1;

        $this->validate();
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }

    public function addToCart(CartServiceInterface $cart)
    {
        $this->validate();

        $cart->addOrUpdate(new CartItemData(
            $this->sku,
            $this->quantity,
            $this->price,
            $this->weight
        ));

        session()->flash('success', 'Produk berhasil ditambahkan ke keranjang!');

        $this->dispatch('cart-updated');

        return redirect()->route('cart');
    }
}
