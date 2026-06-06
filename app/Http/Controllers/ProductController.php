<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['images', 'seller', 'reviews.user'])->findOrFail($id);

        return view('product.show', compact('product'));
    }
}