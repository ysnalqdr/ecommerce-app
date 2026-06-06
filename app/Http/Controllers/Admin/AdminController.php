<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerProfile;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalSellers = SellerProfile::where('status', 'active')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingSellers = SellerProfile::where('status', 'pending')->with('user')->get();

        // Data chart order per bulan
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $orderLabels = collect(range(1, 12))->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)))->toArray();
        $orderData = collect(range(1, 12))->map(fn($m) => $orders->firstWhere('month', $m)?->total ?? 0)->toArray();

        // Data chart produk per kategori
        $categories = Product::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->get();

        $categoryLabels = $categories->pluck('category')->toArray();
        $categoryData = $categories->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSellers', 'totalProducts', 'totalOrders',
            'pendingSellers', 'orderLabels', 'orderData', 'categoryLabels', 'categoryData'
        ));
    }

    public function approveSeller($id)
    {
        $seller = SellerProfile::findOrFail($id);
        $seller->update(['status' => 'active']);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Seller berhasil diapprove!');
    }

    public function rejectSeller($id)
    {
        $seller = SellerProfile::findOrFail($id);
        $seller->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Seller berhasil direject.');
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        $products = Product::with('seller')->latest()->get();
        return view('admin.products', compact('products'));
    }
}