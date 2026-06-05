<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $seller = Auth::user()->sellerProfile;

        if (!$seller || $seller->status !== 'active') {
            return redirect()->route('home')
                ->with('error', 'Kamu belum terdaftar sebagai seller aktif.');
        }

        return $next($request);
    }
}