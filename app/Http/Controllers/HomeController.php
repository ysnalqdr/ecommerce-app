<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Produk terbaru
        $products = Product::with('primaryImage')->latest()->take(12)->get();

        // Produk per kategori untuk section kategori
        $categories = Product::select('category')
            ->distinct()
            ->pluck('category');

        // Rekomendasi berdasarkan riwayat view user
        $recommendations = collect();

        if (Auth::check()) {
            // Ambil kategori yang paling sering dilihat user
            $favoriteCategories = ProductView::where('user_id', Auth::id())
                ->select('category')
                ->groupBy('category')
                ->orderByRaw('COUNT(*) DESC')
                ->limit(3)
                ->pluck('category');

            if ($favoriteCategories->isNotEmpty()) {
                $recommendations = Product::with('primaryImage')
                    ->whereIn('category', $favoriteCategories)
                    ->latest()
                    ->take(8)
                    ->get();
            }
        }

        // Flash sale — ambil 8 produk dengan harga tertinggi sebagai simulasi
        $flashSale = Product::with('primaryImage')
            ->orderBy('price', 'desc')
            ->take(8)
            ->get();

        return view('home', compact(
            'products',
            'categories',
            'recommendations',
            'flashSale'
        ));
    }
}