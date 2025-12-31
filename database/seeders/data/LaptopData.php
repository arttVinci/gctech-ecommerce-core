<?php

namespace Database\Seeders\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Support\Markdown;

class LaptopData
{
    public function getImagePath($name)
    {
        $path = '';

        if (Str::contains($name, ['ROG', 'Strix', 'Zephyrus', 'Flow'])) {
            $path = Arr::random(['asus1.jpg', 'asus2.jpg', 'asus3.jpg']);
        } elseif (Str::contains($name, ['Advan', 'Soulmate', 'Pixelwar', 'Workplus'])) {
            $path = Arr::random(['advan1.jpg', 'advan2.jpg', 'advan3.jpg']);
        } elseif (Str::contains($name, ['Axioo', 'Pongo', 'Hype'])) {
            $path = Arr::random(['axioo1.jpg', 'axioo2.jpg', 'axioo3.jpg']);
        } elseif (Str::contains($name, ['LOQ'])) {
            $path = Arr::random(['lenovo1.jpg', 'lenovo2.jpg', 'lenovo3.jpg', 'lenovo4.jpg', 'lenovo5.jpg']);
        } elseif (Str::contains($name, ['Victus'])) {
            $path = Arr::random(['victus1.jpg', 'victus2.jpg', 'victus3.jpg']);
        } elseif (Str::contains($name, ['Nitro'])) {
            $path = Arr::random(['acer1.jpg', 'acer2.jpg', 'acer3.jpg']);
        } elseif (Str::contains($name, ['MSI'])) {
            $path = Arr::random(['msi1.jpg', 'msi2.jpg', 'msi3.jpg']);
        } else {
            $path = 'default.jpg';
        }

        return storage_path('app/public/media/laptop/' . $path);
    }
    private function productDeskripsi($productName): string
    {
        $specs = [
            'processor' => 'Intel Core i5-12450H / AMD Ryzen 5 7535HS',
            'gpu'       => 'NVIDIA GeForce RTX 2050 / 3050 4GB',
            'ram'       => '8GB DDR5-4800',
            'storage'   => '512GB NVMe SSD',
            'screen'    => '15.6" FHD 144Hz',
            'keyboard'  => 'Backlit Keyboard',
            'battery'   => '50Wh',
            'os'        => 'Windows 11 Home',
        ];

        if (Str::contains($productName, ['Strix', 'SCAR', 'Zephyrus', 'Flow', 'Pongo Studio'])) {
            $specs = [
                'processor' => 'Intel Core i9-14900HX / AMD Ryzen 9 7940HX',
                'gpu'       => 'NVIDIA GeForce RTX 4080 / 4090 12GB/16GB',
                'ram'       => '32GB / 64GB DDR5 Dual Channel',
                'storage'   => '1TB / 2TB PCIe Gen4 Performance SSD',
                'screen'    => '16"/18" ROG Nebula HDR (Mini LED) 240Hz',
                'keyboard'  => 'Per-Key RGB Mechanical Switch',
                'battery'   => '90Wh',
                'os'        => 'Windows 11 Pro',
            ];
        } elseif (Str::contains($productName, ['LOQ', 'Victus', 'Nitro', 'Pongo 760', 'Pongo 960', 'Pixelwar', 'TUF', 'Cyborg', 'Katana'])) {
            $specs = [
                'processor' => 'Intel Core i7-13650HX / Ryzen 7 7840HS',
                'gpu'       => 'NVIDIA GeForce RTX 4050 / 4060 8GB',
                'ram'       => '16GB DDR5 5600MHz',
                'storage'   => '512GB Gen4 SSD',
                'screen'    => '15.6" FHD 144Hz 100% sRGB',
                'keyboard'  => '4-Zone RGB / White Backlit',
                'battery'   => '60Wh - 80Wh',
                'os'        => 'Windows 11 Home',
            ];
        } elseif (Str::contains($productName, ['Soulmate', 'Hype', 'Workplus', 'Workpro', 'Go 14', 'MyBook'])) {
            $specs = [
                'processor' => 'Intel Core i3-N305 / Ryzen 5 6600H',
                'gpu'       => 'Integrated Intel UHD / AMD Radeon 660M',
                'ram'       => '8GB / 16GB LPDDR5',
                'storage'   => '256GB / 512GB SSD',
                'screen'    => '14" FHD IPS Panel',
                'keyboard'  => 'Standard Keyboard',
                'battery'   => '48Wh - 58Wh',
                'os'        => 'Windows 11 Home',
            ];
        }

        return <<<MD
            ### SPESIFIKASI: {$productName}

            **PERFORMANCE**
            - **Processor:** {$specs['processor']}
            - **Graphics:** {$specs['gpu']}
            - **RAM:** {$specs['ram']}
            - **Storage:** {$specs['storage']}
            - **OS:** {$specs['os']}

            **DESAIN & LAYAR**
            - **Layar:** {$specs['screen']}
            - **Keyboard:** {$specs['keyboard']}

            **FITUR LAIN**
            - **Battery:** {$specs['battery']}
            - **Warranty:** Garansi Resmi Indonesia
            MD;
    }

    public function data(): array
    {
        $rawProducts = [
            ['name' => 'Advan Pixelwar - Ryzen 5 6600H - RTX 4050 - 16GB/512GB', 'price' => 9699000, 'weight' => 2100],
            ['name' => 'Advan Workplus - Ryzen 5 6600H - 16GB/512GB - Grey', 'price' => 6999000, 'weight' => 1400],
            ['name' => 'Advan Workplus - Ryzen 5 6600H - 16GB/512GB - Gold', 'price' => 6999000, 'weight' => 1400],
            ['name' => 'Advan Workplus - Ryzen 7 7735HS - 16GB/512GB', 'price' => 7999000, 'weight' => 1400],
            ['name' => 'Advan Workpro - Core i5 1035G7 - 8GB/256GB - Grey', 'price' => 4899000, 'weight' => 1200],
            ['name' => 'Advan Workpro - Core i5 1035G7 - 8GB/512GB - Gold', 'price' => 5199000, 'weight' => 1200],
            ['name' => 'Advan Soulmate - Celeron N4020 - 4GB/128GB - Grey', 'price' => 2499000, 'weight' => 1400],
            ['name' => 'Advan Soulmate - Celeron N4020 - 8GB/256GB - Blue', 'price' => 3199000, 'weight' => 1400],
            ['name' => 'Advan Soulmate - Celeron N4020 - 8GB/256GB - Grey', 'price' => 3199000, 'weight' => 1400],
            ['name' => 'Advan 360 Stylus - i3 1115G4 - 8GB/256GB - Touch', 'price' => 5999000, 'weight' => 1500],
            ['name' => 'Advan 360 Stylus - i5 1135G7 - 16GB/512GB - Touch', 'price' => 6999000, 'weight' => 1500],

            ['name' => 'Axioo Pongo Studio - i9 14900HX - RTX 4070 - 32GB', 'price' => 29999000, 'weight' => 2500],
            ['name' => 'Axioo Pongo 960 - i9 13900H - RTX 4060 - 16GB', 'price' => 19999000, 'weight' => 2300],
            ['name' => 'Axioo Pongo 760 V2 - i7 13620H - RTX 4060 - 16GB', 'price' => 16499000, 'weight' => 2200],
            ['name' => 'Axioo Pongo 760 - i7 12650H - RTX 4060 - 16GB', 'price' => 15499000, 'weight' => 2200],
            ['name' => 'Axioo Pongo 725 - i7 12650H - RTX 2050 - 16GB', 'price' => 9999000, 'weight' => 2200],
            ['name' => 'Axioo Pongo 750 - i7 13620H - RTX 4050 - 16GB', 'price' => 13999000, 'weight' => 2200],
            ['name' => 'Axioo Hype 7 - AMD Ryzen 7 5700U - 16GB/512GB', 'price' => 6299000, 'weight' => 1400],
            ['name' => 'Axioo Hype 5 - AMD Ryzen 5 5500U - 8GB/256GB', 'price' => 4999000, 'weight' => 1400],
            ['name' => 'Axioo Hype 5 - AMD Ryzen 5 5500U - 16GB/512GB', 'price' => 5499000, 'weight' => 1400],
            ['name' => 'Axioo Hype 3 - Core i3 1005G1 - 8GB/256GB', 'price' => 3899000, 'weight' => 1400],
            ['name' => 'Axioo Hype 1 - Celeron N4020 - 4GB/128GB', 'price' => 2499000, 'weight' => 1400],
            ['name' => 'Axioo Hype 10 - Core i3 1215U - 8GB/256GB', 'price' => 4299000, 'weight' => 1400],
            ['name' => 'Axioo MyBook Z10 Metal - i5 1335U - 16GB', 'price' => 8499000, 'weight' => 1300],
            ['name' => 'Axioo MyBook Z6 Metal - i3 1215U - 8GB', 'price' => 6499000, 'weight' => 1300],

            ['name' => 'Lenovo LOQ 15IRX9 - i7 13650HX - RTX 4060 - Grey', 'price' => 18999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IRX9 - i5 13450HX - RTX 4050 - Grey', 'price' => 15499000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IRX9 - i5 13450HX - RTX 3050 - Grey', 'price' => 13999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15APH8 - Ryzen 7 7840HS - RTX 4060', 'price' => 17499000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15APH8 - Ryzen 5 7640HS - RTX 4050', 'price' => 14999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15APH8 - Ryzen 5 7640HS - RTX 3050', 'price' => 12999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IRH8 - i5 12450H - RTX 2050 - 8GB', 'price' => 10999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IRH8 - i5 12450H - RTX 3050 - 8GB', 'price' => 11999000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IRH8 - i5 12450H - RTX 4050 - 16GB', 'price' => 13499000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IAX9 - i5 12450HX - RTX 2050 - 12GB', 'price' => 11499000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IAX9 - i5 12450HX - RTX 3050 - 12GB', 'price' => 12499000, 'weight' => 2400],
            ['name' => 'Lenovo LOQ 15IAX9 - i5 12450HX - RTX 4050 - 24GB', 'price' => 14999000, 'weight' => 2400],

            ['name' => 'HP Victus 16-r0029TX - i7 13700H - RTX 4060 - Mica Silver', 'price' => 19499000, 'weight' => 2350],
            ['name' => 'HP Victus 16-r0029TX - i7 13700H - RTX 4070 - White', 'price' => 23499000, 'weight' => 2350],
            ['name' => 'HP Victus 16-s0009AX - Ryzen 7 7840HS - RTX 4060', 'price' => 18499000, 'weight' => 2350],
            ['name' => 'HP Victus 16-s0009AX - Ryzen 5 7640HS - RTX 4050', 'price' => 16499000, 'weight' => 2350],
            ['name' => 'HP Victus 15-fa1093TX - i5 13420H - RTX 4050 - Blue', 'price' => 13499000, 'weight' => 2290],
            ['name' => 'HP Victus 15-fa1093TX - i5 13420H - RTX 3050 - Silver', 'price' => 11999000, 'weight' => 2290],
            ['name' => 'HP Victus 15-fa0116TX - i5 12500H - RTX 3050', 'price' => 11299000, 'weight' => 2290],
            ['name' => 'HP Victus 15-fb0009AX - Ryzen 5 5600H - RTX 3050', 'price' => 10999000, 'weight' => 2290],
            ['name' => 'HP Victus 15-fb1009AX - Ryzen 5 7535HS - RTX 2050', 'price' => 9999000, 'weight' => 2290],
            ['name' => 'HP Victus 15-fa1111TX - i5 12450H - RTX 2050', 'price' => 10499000, 'weight' => 2290],

            ['name' => 'Acer Nitro 16 AN16 - Ryzen 7 7735HS - RTX 4070', 'price' => 21999000, 'weight' => 2700],
            ['name' => 'Acer Nitro 16 AN16 - Ryzen 7 7735HS - RTX 4060', 'price' => 19999000, 'weight' => 2700],
            ['name' => 'Acer Nitro 5 AN515 - i7 12700H - RTX 3060 - 16GB', 'price' => 15999000, 'weight' => 2500],
            ['name' => 'Acer Nitro 5 AN515 - i5 12500H - RTX 3050 - 8GB', 'price' => 12499000, 'weight' => 2500],
            ['name' => 'Acer Nitro V 15 ANV15 - i5 13420H - RTX 4050 - 8GB', 'price' => 12999000, 'weight' => 2100],
            ['name' => 'Acer Nitro V 15 ANV15 - i5 13420H - RTX 4050 - 16GB', 'price' => 13499000, 'weight' => 2100],
            ['name' => 'Acer Nitro V 15 ANV15 - i5 13420H - RTX 2050 - 8GB', 'price' => 10999000, 'weight' => 2100],
            ['name' => 'Acer Nitro V 15 ANV15 - i5 13420H - RTX 2050 - 16GB', 'price' => 11499000, 'weight' => 2100],
            ['name' => 'Acer Nitro V 16 ANV16 - Ryzen 7 8845HS - RTX 4060', 'price' => 18999000, 'weight' => 2300],
            ['name' => 'Acer Nitro V 16 ANV16 - Ryzen 5 8645HS - RTX 4050', 'price' => 15999000, 'weight' => 2300],

            ['name' => 'ASUS ROG Strix SCAR 18 (2024) - i9 14900HX - RTX 4090', 'price' => 69999000, 'weight' => 3100],
            ['name' => 'ASUS ROG Strix SCAR 18 (2024) - i9 14900HX - RTX 4080', 'price' => 59999000, 'weight' => 3100],
            ['name' => 'ASUS ROG Strix SCAR 16 (2024) - i9 14900HX - RTX 4090', 'price' => 67999000, 'weight' => 2600],
            ['name' => 'ASUS ROG Strix SCAR 16 (2024) - i9 14900HX - RTX 4080', 'price' => 55999000, 'weight' => 2600],
            ['name' => 'ASUS ROG Strix G18 (2024) - i9 14900HX - RTX 4070', 'price' => 38999000, 'weight' => 3000],
            ['name' => 'ASUS ROG Strix G18 (2024) - i9 14900HX - RTX 4060', 'price' => 32999000, 'weight' => 3000],
            ['name' => 'ASUS ROG Strix G16 (2024) - i9 13980HX - RTX 4070', 'price' => 32999000, 'weight' => 2500],
            ['name' => 'ASUS ROG Strix G16 (2024) - i9 13980HX - RTX 4060', 'price' => 28999000, 'weight' => 2500],
            ['name' => 'ASUS ROG Strix G16 (2024) - i9 13980HX - RTX 4050', 'price' => 25999000, 'weight' => 2500],
            ['name' => 'ASUS ROG Zephyrus G14 (2024) OLED - Ryzen 9 - RTX 4070', 'price' => 39999000, 'weight' => 1500],
            ['name' => 'ASUS ROG Zephyrus G14 (2024) OLED - Ryzen 9 - RTX 4060', 'price' => 34999000, 'weight' => 1500],
            ['name' => 'ASUS ROG Zephyrus G14 (2024) OLED - Ryzen 7 - RTX 4050', 'price' => 29999000, 'weight' => 1500],
            ['name' => 'ASUS ROG Zephyrus G16 (2024) OLED - Ultra 9 - RTX 4090', 'price' => 64999000, 'weight' => 1850],
            ['name' => 'ASUS ROG Zephyrus G16 (2024) OLED - Ultra 9 - RTX 4080', 'price' => 54999000, 'weight' => 1850],
            ['name' => 'ASUS ROG Zephyrus G16 (2024) OLED - Ultra 9 - RTX 4070', 'price' => 41999000, 'weight' => 1850],
            ['name' => 'ASUS ROG Zephyrus G16 (2024) OLED - Ultra 7 - RTX 4060', 'price' => 35999000, 'weight' => 1850],
            ['name' => 'ASUS ROG Zephyrus G16 (2024) OLED - Ultra 7 - RTX 4050', 'price' => 30999000, 'weight' => 1850],
            ['name' => 'ASUS ROG Zephyrus M16 (2023) - i9 13900H - RTX 4090', 'price' => 61999000, 'weight' => 1900],
            ['name' => 'ASUS ROG Zephyrus M16 (2023) - i9 13900H - RTX 4080', 'price' => 51999000, 'weight' => 1900],
            ['name' => 'ASUS ROG Zephyrus M16 (2023) - i9 13900H - RTX 4070', 'price' => 36999000, 'weight' => 1900],
            ['name' => 'ASUS ROG Flow X13 (2023) - Ryzen 9 - RTX 4070', 'price' => 32999000, 'weight' => 1300],
            ['name' => 'ASUS ROG Flow X13 (2023) - Ryzen 9 - RTX 4060', 'price' => 29999000, 'weight' => 1300],
            ['name' => 'ASUS ROG Flow X13 (2023) - Ryzen 9 - RTX 4050', 'price' => 27999000, 'weight' => 1300],
            ['name' => 'ASUS ROG Flow Z13 (2023) - i9 13900H - RTX 4060', 'price' => 31999000, 'weight' => 1180],
            ['name' => 'ASUS ROG Flow Z13 (2023) - i9 13900H - RTX 4050', 'price' => 29999000, 'weight' => 1180],
            ['name' => 'ASUS ROG Flow Z13 ACRNM - i9 13900H - RTX 4070', 'price' => 44999000, 'weight' => 1300],
            ['name' => 'ASUS ROG Flow X16 (2023) - i9 13900H - RTX 4070', 'price' => 42999000, 'weight' => 2100],
            ['name' => 'ASUS ROG Flow X16 (2023) - i9 13900H - RTX 4060', 'price' => 38999000, 'weight' => 2100],
            ['name' => 'ASUS ROG Flow X16 (2023) - i9 13900H - RTX 4050', 'price' => 34999000, 'weight' => 2100],

            ['name' => 'MSI Cyborg 15 - i7 12650H - RTX 4060', 'price' => 15999000, 'weight' => 1980],
            ['name' => 'MSI Cyborg 15 - i5 12450H - RTX 4050', 'price' => 12999000, 'weight' => 1980],
            ['name' => 'MSI Cyborg 15 - i5 12450H - RTX 2050', 'price' => 10999000, 'weight' => 1980],
            ['name' => 'MSI Katana 15 - i9 13900H - RTX 4070', 'price' => 24999000, 'weight' => 2250],
            ['name' => 'MSI Katana 15 - i7 13620H - RTX 4060', 'price' => 18999000, 'weight' => 2250],
            ['name' => 'MSI Katana 15 - i7 13620H - RTX 4050', 'price' => 16999000, 'weight' => 2250],
        ];

        return array_map(function ($item) {
            return [
                'name'       => $item['name'],
                'slug'       => Str::slug($item['name']),
                'sku'        => strtoupper(Str::slug($item['name'])),
                'deskripsi'  => $this->productDeskripsi($item['name']),
                'weight'     => $item['weight'],
                'price'      => $item['price'],
                'stock'      => rand(5, 50),
                'created_at' => now(),
                'updated_at' => now(),

                'local_image_path' => $this->getImagePath($item['name']),
            ];
        }, $rawProducts);
    }
}
