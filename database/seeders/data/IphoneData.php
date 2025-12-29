<?php

namespace Database\Seeders\Data;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class iPhoneData
{
    private function productDeskripsi($productName)
    {
        //default
        $specs = [
            'chipset' => 'Apple A19 Pro',
            'screen_type' => 'Layar cemerlang dengan sudut melengkung',
            'camera_main' => 'Sistem kamera Pro dengan semua kamera 48 MP',
            'zoom' => 'Hingga 8x zoom kualitas optik',
            'battery' => 'Hingga 33 jam pemutaran video',
            'charging' => 'Hingga 50 persen dalam 20 menit',
            'os' => 'iOS 26',
            'feature' => 'Center Stage Dual Capture'
        ];

        if (Str::contains($productName, ['iPhone X', 'iPhone XS', 'iPhone XR'])) {
            $specs = [
                'chipset' => 'Apple A11 / A12 Bionic',
                'screen_type' => 'Super Retina OLED / Liquid Retina LCD',
                'camera_main' => 'Dual 12 MP (Wide, Telephoto)',
                'zoom' => '2x Optical Zoom',
                'battery' => 'Hingga 13-15 jam pemutaran video',
                'charging' => 'Fast charging 15W',
                'os' => 'iOS 12 (Upgradeable to latest)',
                'feature' => 'Face ID First Gen'
            ];
        } elseif (Str::contains($productName, ['iPhone 11', 'iPhone 12'])) {
            $specs = [
                'chipset' => 'Apple A13 / A14 Bionic',
                'screen_type' => 'Super Retina XDR OLED',
                'camera_main' => 'Dual/Triple 12 MP System',
                'zoom' => '2x - 2.5x Optical Zoom',
                'battery' => 'Hingga 17 jam pemutaran video',
                'charging' => 'Fast charging 20W',
                'os' => 'iOS 14 (Upgradeable)',
                'feature' => 'Night Mode & Deep Fusion'
            ];
        } elseif (Str::contains($productName, ['iPhone 13', 'iPhone 14'])) {
            $specs = [
                'chipset' => 'Apple A15 / A16 Bionic',
                'screen_type' => 'Super Retina XDR with ProMotion (Pro models)',
                'camera_main' => '12 MP / 48 MP (Pro models)',
                'zoom' => '3x Optical Zoom',
                'battery' => 'Hingga 20-29 jam pemutaran video',
                'charging' => 'MagSafe Charging supported',
                'os' => 'iOS 16',
                'feature' => 'Cinematic Mode & Action Mode'
            ];
        } elseif (Str::contains($productName, ['iPhone 15', 'iPhone 16'])) {
            $specs = [
                'chipset' => 'Apple A17 Pro / A18 Bionic',
                'screen_type' => 'Super Retina XDR (Always-On Display)',
                'camera_main' => '48 MP Main Camera System',
                'zoom' => '5x Optical Zoom (Pro Max)',
                'battery' => 'Hingga 29 jam pemutaran video',
                'charging' => 'USB-C Fast Charging',
                'os' => 'iOS 17 / iOS 18',
                'feature' => 'Dynamic Island & Camera Control'
            ];
        }

        return <<<MD
        ### SPESIFIKASI: {$productName}

        **DESAIN & LAYAR**
        - **Ukuran Layar:** 6.1 inci (Pro/Base) / 6.7 inci (Max/Plus)
        - **Tipe Layar:** {$specs['screen_type']}
        - **Material Bodi:** Unibody aluminium / Stainless Steel / Titanium
        - **Perlindungan Layar:** Ceramic Shield (Depan)
        - **Desain:** Tangguh dan Elegan

        **PERFORMA**
        - **Chipset:** **{$specs['chipset']}**
        - **Sistem Pendingin:** High efficiency thermal system
        - **Performa:** CPU dan GPU kelas atas untuk multitasking berat

        **KAMERA**
        - **Kamera Belakang:** {$specs['camera_main']}
        - **Zoom:** {$specs['zoom']}
        - **Fitur Kamera:** Fotografi komputasional, Night Mode, Portrait
        - **Kamera Depan:** TrueDepth Camera
        - **Fitur Unik:** {$specs['feature']}

        **BATERAI & DAYA**
        - **Daya Tahan:** {$specs['battery']}
        - **Pengisian Cepat:** {$specs['charging']}

        **SOFTWARE**
        - **Sistem Operasi:** {$specs['os']}
        - **Antarmuka:** iOS Interface yang intuitif
        - **Fitur Tambahan:** Widget interaktif & Fokus mode

        **KONEKTIVITAS**
        - **Jaringan:** 5G / 4G LTE
        - **Wi Fi:** Wi-Fi 6 / 6E / 7 (Tergantung model)
        - **Bluetooth:** Bluetooth 5.0 / 5.3
        - **SIM:** Dual SIM (nano-SIM dan eSIM)

        **KEAMANAN & PRIVASI**
        - **Fitur Keselamatan:** Emergency SOS / Crash Detection
        - **Keamanan:** Face ID aman & Data terenkripsi

        **LAINNYA**
        - **Audio:** Spatial Audio & Dolby Atmos
        - **Ekosistem:** Integrasi penuh dengan iPad, Mac, dan Apple Watch
        MD;
    }
    public function data(): array
    {
        $data = [
            // iPhone X Series
            [
                'name' => 'Apple iPhone X - 64GB - Space Gray',
                'weight' => 174,
                'price' => 4500000
            ],
            [
                'name' => 'Apple iPhone XR - 128GB - Coral',
                'weight' => 194,
                'price' => 5200000
            ],
            [
                'name' => 'Apple iPhone XS Max - 256GB - Gold',
                'weight' => 208,
                'price' => 6100000
            ],

            // iPhone 11 Series
            [
                'name' => 'Apple iPhone 11 - 128GB - Black',
                'weight' => 194,
                'price' => 7000000
            ],
            [
                'name' => 'Apple iPhone 11 Pro - 256GB - Midnight Green',
                'weight' => 188,
                'price' => 8500000
            ],

            // iPhone 12 Series
            [
                'name' => 'Apple iPhone 12 - 128GB - Blue',
                'weight' => 164,
                'price' => 9500000
            ],
            [
                'name' => 'Apple iPhone 12 Pro Max - 256GB - Pacific Blue',
                'weight' => 228,
                'price' => 11500000
            ],

            // iPhone 13 Series
            [
                'name' => 'Apple iPhone 13 Mini - 128GB - Pink',
                'weight' => 141,
                'price' => 10500000
            ],
            [
                'name' => 'Apple iPhone 13 Pro - 256GB - Sierra Blue',
                'weight' => 204,
                'price' => 13500000
            ],

            // iPhone 14 Series
            [
                'name' => 'Apple iPhone 14 - 128GB - Purple',
                'weight' => 172,
                'price' => 12500000
            ],
            [
                'name' => 'Apple iPhone 14 Pro Max - 256GB - Deep Purple',
                'weight' => 240,
                'price' => 16500000
            ],

            // iPhone 15 Series
            [
                'name' => 'Apple iPhone 15 - 128GB - Pink',
                'weight' => 171,
                'price' => 14500000
            ],
            [
                'name' => 'Apple iPhone 15 Pro - 256GB - Natural Titanium',
                'weight' => 187,
                'price' => 19000000
            ],

            // iPhone 16 Series
            [
                'name' => 'Apple iPhone 16 - 128GB - Ultramarine',
                'weight' => 170,
                'price' => 16500000
            ],
            [
                'name' => 'Apple iPhone 16 Pro Max - 256GB - Desert Titanium',
                'weight' => 227,
                'price' => 22000000
            ],

            // iPhone 17 (Coming Soon / Mockup Data)
            [
                'name' => 'Apple iPhone 17 Pro - 256GB - Titanium Silver',
                'weight' => 185,
                'price' => 24000000
            ],
        ];

        return array_map(function ($item) {
            return [
                'name'       => $item['name'],
                'slug'       => Str::slug($item['name']),
                'sku'        => strtoupper(Str::slug($item['name'])),
                'deskripsi'  => $this->productDeskripsi($item['name']),
                'weight'     => $item['weight'],
                'price'      => $item['price'],
                'stock'      => rand(20, 70),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $data);
    }
}
