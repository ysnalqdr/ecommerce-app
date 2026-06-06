<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600">TokoKu</h1>
        <div class="flex gap-4 items-center">
            @auth
                <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Dashboard</a>
                @if (!auth()->user()->sellerProfile)
                    <a href="{{ route('seller.register') }}"
                        class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">Jadi Seller</a>
                @else
                    <a href="{{ route('seller.dashboard') }}" class="text-indigo-600 hover:underline">Toko Saya</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="bg-indigo-600 text-white text-center py-16 px-4">
        <h2 class="text-4xl font-bold mb-2">Belanja Mudah, Harga Terbaik</h2>
        <p class="text-indigo-200 mb-6">Temukan produk favoritmu dari seller terpercaya</p>
        <a href="#produk" class="bg-white text-indigo-600 font-semibold px-6 py-2 rounded-full hover:bg-indigo-50">Lihat
            Produk</a>
    </div>

    {{-- Daftar Produk --}}
    <div id="produk" class="max-w-6xl mx-auto px-4 py-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Produk Terbaru</h3>

        @if ($products->isEmpty())
            <p class="text-gray-500">Belum ada produk tersedia.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <a href="{{ route('product.show', $product->id) }}"
                        class="bg-white rounded-xl shadow hover:shadow-md transition p-4 block">
                        <div class="bg-gray-200 rounded-lg h-40 mb-3 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">No Image</span>
                        </div>
                        <h4 class="font-semibold text-gray-800 truncate">{{ $product->name }}</h4>
                        <p class="text-indigo-600 font-bold mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-400 text-xs mt-1">Stok: {{ $product->stock }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</body>

</html>
