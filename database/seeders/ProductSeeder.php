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

        $products = [
            ['name' => 'Kaos Polos Premium', 'category' => 'Fashion', 'price' => 85000, 'stock' => 50, 'description' => 'Kaos polos berbahan cotton combed 30s, nyaman dipakai sehari-hari.'],
            ['name' => 'Celana Jogger Pria', 'category' => 'Fashion', 'price' => 120000, 'stock' => 30, 'description' => 'Celana jogger bahan fleece, cocok untuk santai maupun olahraga.'],
            ['name' => 'Sepatu Sneakers Casual', 'category' => 'Sepatu', 'price' => 350000, 'stock' => 20, 'description' => 'Sepatu sneakers casual dengan sol karet anti slip.'],
            ['name' => 'Tas Ransel Laptop', 'category' => 'Tas', 'price' => 275000, 'stock' => 15, 'description' => 'Tas ransel dengan kompartemen laptop hingga 15 inch.'],
            ['name' => 'Jam Tangan Digital', 'category' => 'Aksesoris', 'price' => 195000, 'stock' => 25, 'description' => 'Jam tangan digital dengan fitur alarm dan stopwatch.'],
            ['name' => 'Earphone Bluetooth', 'category' => 'Elektronik', 'price' => 250000, 'stock' => 40, 'description' => 'Earphone bluetooth dengan bass yang kuat dan baterai tahan lama.'],
            ['name' => 'Power Bank 10000mAh', 'category' => 'Elektronik', 'price' => 180000, 'stock' => 35, 'description' => 'Power bank kapasitas 10000mAh dengan pengisian cepat.'],
            ['name' => 'Kemeja Flannel', 'category' => 'Fashion', 'price' => 150000, 'stock' => 45, 'description' => 'Kemeja flannel motif kotak-kotak, cocok untuk casual wear.'],
        ];

        foreach ($products as $product) {
            Product::create([
                'seller_id' => $seller->id,
                'name' => $product['name'],
                'category' => $product['category'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'description' => $product['description'],
            ]);
        }

        echo "8 produk berhasil ditambahkan!\n";
    }
}