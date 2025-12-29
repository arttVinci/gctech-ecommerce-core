<?php

namespace Database\Seeders;

use App\Models\Product;
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
            new LaptopData()
        ];

        foreach ($dataSources as $data) {
            $productData = $data->data();

            foreach ($productData as $item) {
                $imagePath = $item['local_image_path'] ?? null;

                unset($item['local_image_path']);

                $product = Product::create($item);

                // dd($imagePath);

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