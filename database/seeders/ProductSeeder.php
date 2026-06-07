<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SellerProfile;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller = SellerProfile::first();

        if (!$seller) {
            echo "Tidak ada seller. Jalankan seeder setelah ada seller aktif.\n";
            return;
        }

\Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Product::truncate();
\Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            [
                'name' => 'Kaos Polos Premium',
                'category' => 'Fashion',
                'price' => 65000,
                'original_price' => 85000,
                'discount_percent' => 24,
                'total_sold' => 1200,
                'badge' => 'local',
                'stock' => 50,
                'description' => 'Kaos polos berbahan cotton combed 30s, nyaman dipakai sehari-hari.',
            ],
            [
                'name' => 'Celana Jogger Pria',
                'category' => 'Fashion',
                'price' => 120000,
                'original_price' => null,
                'discount_percent' => 0,
                'total_sold' => 850,
                'badge' => 'local',
                'stock' => 30,
                'description' => 'Celana jogger bahan fleece, cocok untuk santai maupun olahraga.',
            ],
            [
                'name' => 'Sepatu Sneakers Casual',
                'category' => 'Sepatu',
                'price' => 299000,
                'original_price' => 350000,
                'discount_percent' => 15,
                'total_sold' => 3200,
                'badge' => 'official',
                'stock' => 20,
                'description' => 'Sepatu sneakers casual dengan sol karet anti slip.',
            ],
            [
                'name' => 'Tas Ransel Laptop',
                'category' => 'Tas',
                'price' => 275000,
                'original_price' => null,
                'discount_percent' => 0,
                'total_sold' => 540,
                'badge' => 'official',
                'stock' => 15,
                'description' => 'Tas ransel dengan kompartemen laptop hingga 15 inch.',
            ],
            [
                'name' => 'Jam Tangan Digital',
                'category' => 'Aksesoris',
                'price' => 150000,
                'original_price' => 195000,
                'discount_percent' => 23,
                'total_sold' => 980,
                'badge' => 'none',
                'stock' => 25,
                'description' => 'Jam tangan digital dengan fitur alarm dan stopwatch.',
            ],
            [
                'name' => 'Earphone Bluetooth',
                'category' => 'Elektronik',
                'price' => 199000,
                'original_price' => 250000,
                'discount_percent' => 20,
                'total_sold' => 4500,
                'badge' => 'official',
                'stock' => 40,
                'description' => 'Earphone bluetooth dengan bass yang kuat dan baterai tahan lama.',
            ],
            [
                'name' => 'Power Bank 10000mAh',
                'category' => 'Elektronik',
                'price' => 180000,
                'original_price' => null,
                'discount_percent' => 0,
                'total_sold' => 2100,
                'badge' => 'none',
                'stock' => 35,
                'description' => 'Power bank kapasitas 10000mAh dengan pengisian cepat.',
            ],
            [
                'name' => 'Kemeja Flannel',
                'category' => 'Fashion',
                'price' => 115000,
                'original_price' => 150000,
                'discount_percent' => 23,
                'total_sold' => 760,
                'badge' => 'local',
                'stock' => 45,
                'description' => 'Kemeja flannel motif kotak-kotak, cocok untuk casual wear.',
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'seller_id' => $seller->id,
                'name' => $product['name'],
                'category' => $product['category'],
                'price' => $product['price'],
                'original_price' => $product['original_price'],
                'discount_percent' => $product['discount_percent'],
                'total_sold' => $product['total_sold'],
                'badge' => $product['badge'],
                'stock' => $product['stock'],
                'description' => $product['description'],
            ]);
        }

        echo "8 produk berhasil ditambahkan!\n";
    }
}