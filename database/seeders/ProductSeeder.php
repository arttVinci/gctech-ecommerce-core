<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Data\IphoneData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dataSources = [
            new IphoneData(),
        ];

        foreach ($dataSources as $source) {
            $readyToInsert = $source->data();
            foreach (array_chunk($readyToInsert, 500) as $chunk) {
                DB::table('products')->insert($chunk);
            }
        }
    }
}
