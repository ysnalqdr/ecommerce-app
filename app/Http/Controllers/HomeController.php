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

        // Kategori dengan gambar produk pertama
        $categories = Product::with('primaryImage')
            ->select('category')
            ->selectRaw('MIN(id) as first_product_id')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $product = Product::with('primaryImage')->find($item->first_product_id);
                return [
                    'name' => $item->category,
                    'image' => $product?->primaryImage?->image_url,
                ];
            });

        // Rekomendasi
        $recommendations = collect();
        if (Auth::check()) {
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

        // Flash sale
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