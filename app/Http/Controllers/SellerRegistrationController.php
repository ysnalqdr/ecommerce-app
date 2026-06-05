<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerRegistrationController extends Controller
{
    // Tampilkan form daftar seller
    public function create()
    {
        $existingSeller = Auth::user()->sellerProfile;

        if ($existingSeller) {
            return redirect()->route('home')
                ->with('info', 'Kamu sudah mendaftar sebagai seller.');
        }

        return view('seller.register');
    }

    // Simpan data pendaftaran seller
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        SellerProfile::create([
            'user_id' => Auth::id(),
            'store_name' => $request->store_name,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('home')
            ->with('success', 'Pendaftaran seller berhasil! Tunggu persetujuan admin.');
    }
}