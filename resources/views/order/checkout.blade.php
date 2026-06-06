<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TokoKu</a>
        <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Checkout</h2>

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Form Alamat --}}
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Alamat Pengiriman</h3>

                    <form method="POST" action="{{ route('order.store') }}">
                        @csrf

                        @if($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 mb-4 text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled
                                class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea
                                name="shipping_address"
                                rows="4"
                                placeholder="Contoh: Jl. Sudirman No. 10, Kelurahan X, Kecamatan Y, Kota Z, 12345"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >{{ old('shipping_address') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                            Buat Pesanan
                        </button>

                    </form>
                </div>
            </div>

            {{-- Ringkasan Order --}}
            <div class="w-full lg:w-80">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Ringkasan Pesanan</h3>

                    @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    <div class="border-t pt-4 mt-4 flex justify-between font-bold text-gray-800">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="block text-center text-indigo-600 hover:underline mt-4 text-sm">
                    ← Kembali ke Keranjang
                </a>
            </div>

        </div>
    </div>

</body>
</html>