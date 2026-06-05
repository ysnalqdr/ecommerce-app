<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $seller = Auth::user()->sellerProfile;
        $products = $seller->products()->latest()->get();
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');

        return view('seller.dashboard', compact(
            'seller',
            'products',
            'totalProducts',
            'totalStock'
        ));
    }
}