<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['images', 'seller', 'reviews.user'])->findOrFail($id);

        // Simpan riwayat view kalau user sudah login
        if (Auth::check()) {
            ProductView::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'category' => $product->category,
            ]);
        }

        return view('product.show', compact('product'));
    }
}