<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Data\ProductData;

class HomePage extends Component
{

    public array $product_kategori = [];

    public function mount()
    {
        $this->product_kategori = [
            [
                'name'          =>      'Laptop',
                'img_url'       =>      'media/laptop-kategori.jpg'
            ],
            [
                'name'          =>      'iPhone',
                'img_url'       =>      'media/iphone-kategori.jpg'
            ],
            [
                'name'          =>      'Smartwatch',
                'img_url'       =>      'media/smartwatch-kategori.jpg'
            ]
        ];
    }

    public function render()
    {
        $feature_products = ProductData::collect(
            Product::query()->inRandomOrder()->limit(4)->get()
        );

        $latest_products = ProductData::collect(
            Product::query()->latest()->limit(4)->get()
        );

        $product_kategori = $this->product_kategori;

        return view('livewire.home-page', compact([
            'feature_products',
            'latest_products',
            'product_kategori'
        ]));
    }
}
