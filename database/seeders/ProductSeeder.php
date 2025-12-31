<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Seeders\Data\SmartwatchData;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Database\Seeders\Data\IphoneData;
use Database\Seeders\Data\LaptopData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dataSources = [
            new IphoneData(),
            new LaptopData(),
            new SmartwatchData()
        ];

        foreach ($dataSources as $data) {
            $productData = $data->data();

            foreach ($productData as $item) {
                $imagePath = $item['local_image_path'] ?? null;

                unset($item['local_image_path']);

                $product = Product::create($item);

                $tag = match (true) {
                    Str::contains($item['name'], 'ASUS')  => 'Asus ROG',
                    Str::contains($item['name'], 'Lenovo')  => 'Lenovo LOQ',
                    Str::contains($item['name'], 'Advan')  => 'Advan Work',
                    Str::contains($item['name'], 'Axioo')  => 'Axioo PONGO',
                    Str::contains($item['name'], 'Acer')  => 'Acer Nitro',
                    Str::contains($item['name'], 'HP')  => 'HP Victus',
                    Str::contains($item['name'], 'MSI')  => 'MSI',
                    default => 'Laptop Gaming'
                };

                if (Str::contains($item['name'], ['ASUS', 'Lenovo', 'Axioo', 'Advan', 'Acer', 'HP', 'MSI'])) {
                    $product->attachTags([$tag, 'Laptop'], 'collection');
                } elseif (Str::contains($item['name'], ['Apple', 'Iphone'])) {
                    $product->attachTags(['Iphone'], 'collection');
                } elseif (Str::contains($item['name'], ['Watch', 'Smart'])) {
                    $product->attachTags(['SmartWatch'], 'collection');
                }

                if ($imagePath && File::exists($imagePath)) {

                    try {
                        $product->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('cover');
                    } catch (\Exception $e) {
                        $this->command->error("Gagal upload gambar untuk: " . $item['name']);
                        Log::error($e);
                    }
                }
            }
        }
    }
}
