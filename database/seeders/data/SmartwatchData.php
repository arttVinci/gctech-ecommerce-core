<?php

namespace Database\Seeders\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Support\Markdown;

class SmartwatchData
{
    private function getImagePath($name)
    {
        $path = '';

        if (Str::contains($name, 'Apple')) {
            $path = Arr::random(['apple.jpg', 'apple2.jpg']);
        }
        if (Str::contains($name, 'Xiaomi')) {
            $path = Arr::random(['xiaomi.jpg', 'xiaomi2.jpg']);
        }
        if (Str::contains($name, 'Realme')) {
            $path = Arr::random(['realme.jpg', 'realme2.jpg']);
        }
        if (Str::contains($name, 'Huawei')) {
            $path = Arr::random(['huawei.jpg', 'huawei2.jpg']);
        }

        return storage_path('app/public/media/smartwatch/' . $path);
    }

    private function productDeskripsi($name): string
    {
        $desk = [];

        if (Str::contains($name, 'Apple')) {
            $desk = [
                'name'      =>      $name,
                'aplikasi'  =>      'Apple IOS'
            ];
        }

        if (Str::contains($name, 'Xiaomi')) {
            $desk = [
                'name'      =>      $name,
                'aplikasi'  =>      'Xiaomi Hyper OS'
            ];
        }

        if (Str::contains($name, 'Realme')) {
            $desk = [
                'name'      =>      $name,
                'aplikasi'  =>      'Realme Link'
            ];
        }

        if (Str::contains($name, 'Huawei')) {
            $desk = [
                'name'      =>      $name,
                'aplikasi'  =>      'Huawei OS'
            ];
        }

        return <<<MD
        # Realme Watch 5
        
        **Ready Stock! Original 100%! Siap Kirim!**
        🛡️ **Garansi Resmi 1 Tahun**

        ## ✨ Fitur Utama
        **Display:** AMOLED 1.97" (600nits Brightness, 60Hz Refresh Rate)
        **Navigation:** Compass and GPS independent with 5 GNSS
        **Health & Sport:** 108 Sports Mode & Health Monitoring
        **Battery:** Super Long Lasting Battery Up to 16 Days
        **Durability:** IP68 Dust & Water Resistance
        **Connectivity:** NFC Card, High Definition Bluetooth Call & Independent Bluetooth Intercom
        **Other Features:**
            * Game Guardian Mode
            * 300+ Watch Face Themes
            * Music Playback & Control
            * Aluminium Alloy Crown & Honeycomb Speaker

        ---

        ## ⚙️ Spesifikasi

        | Kategori | Detail |
        | :--- | :--- |
        | **Berat** | 50g |
        | **Dimensi** | 47.6 x 42.5 x 11.7 mm |
        | **Tipe Layar** | AMOLED |
        | **Ukuran Layar** | 1.97" |
        | **Resolusi** | 390 x 450 pixel (PPI 302) |
        | **Rasio Layar** | Screen to Body Ratio 79% |
        | **Kecerahan** | 600nits |
        | **Refresh Rate** | 60Hz |
        | **Material Strap** | Silica gel, stainless steel (Width: 22mm, Removable) |
        | **Kapasitas Baterai** | 460mAh |
        | **Daya Tahan Baterai** | Up to 16 Days (Standard) / 6 Days (AOD) / 20 Days (Light Mode) |
        | **Bluetooth** | Version 5.3 |
        | **Sensor** | Accelerometer, Heart Rate, SpO2, Compass |
        | **Aplikasi** | {$desk['aplikasi']} |

        ---

        ## 📦 Kelengkapan Dalam Box
        * 1x {$desk['name']}
        * 1x Charging Cable
        * 1x User Guide & Warranty Card
        MD;
    }
    public function data()
    {
        $products = [
            // --- Apple ---
            [
                'name' => 'Apple Watch Series 9 - 41mm - Starlight',
                'weight' => 32,
                'price' => 7999000
            ],
            [
                'name' => 'Apple Watch SE Gen 2 - 44mm - Midnight',
                'weight' => 33,
                'price' => 4999000
            ],
            [
                'name' => 'Apple Watch Ultra 2 - Titanium - Alpine Loop',
                'weight' => 61,
                'price' => 13999000
            ],

            // --- Huawei ---
            [
                'name' => 'Huawei Watch GT 4 - 46mm - Grey Stainless',
                'weight' => 48,
                'price' => 3499000
            ],
            [
                'name' => 'Huawei Watch Fit 3 - Moon White',
                'weight' => 26,
                'price' => 1999000
            ],
            [
                'name' => 'Huawei Band 9 - Starry Black',
                'weight' => 14,
                'price' => 599000
            ],

            // --- Xiaomi ---
            [
                'name' => 'Xiaomi Watch 2 Pro - Black Case',
                'weight' => 54,
                'price' => 3199000
            ],
            [
                'name' => 'Xiaomi Smart Band 8 - Champagne Gold',
                'weight' => 27,
                'price' => 549000
            ],

            // --- Realme ---
            [
                'name' => 'Realme Watch 3 Pro - Black',
                'weight' => 40,
                'price' => 899000
            ],
            [
                'name' => 'Realme Watch S - Master Edition',
                'weight' => 48,
                'price' => 999000
            ]
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
        }, $products);
    }
}
