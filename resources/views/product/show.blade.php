<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TokoKu</a>
        <div class="flex gap-4 items-center">
            @auth
                <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">Register</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">

        {{-- Breadcrumb --}}
        <p class="text-sm text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:underline">Beranda</a> → {{ $product->name }}
        </p>

        <div class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row gap-8">

            {{-- Gambar Produk --}}
            <div class="w-full md:w-1/2">
                @php use Illuminate\Support\Facades\Storage; @endphp
                <div class="rounded-xl h-72 overflow-hidden bg-gray-200">
                    @if ($product->primaryImage)
                        <img src="{{ Storage::url($product->primaryImage->image_url) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info Produk --}}
            <div class="w-full md:w-1/2">
                <p class="text-sm text-indigo-500 font-medium mb-1">{{ $product->category }}</p>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-indigo-600 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p class="text-gray-600 text-sm mb-4">{{ $product->description }}</p>

                <p class="text-sm text-gray-500 mb-6">
                    Stok tersedia: <span class="font-semibold text-gray-700">{{ $product->stock }}</span>
                </p>

                {{-- Info Seller --}}
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <p class="text-xs text-gray-400 mb-1">Dijual oleh</p>
                    <p class="font-semibold text-gray-700">{{ $product->seller->store_name }}</p>
                </div>

                {{-- Tombol Aksi --}}
                @auth
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="flex-1 bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                                + Keranjang
                            </button>
                        </form>
                        <a href="{{ route('cart.index') }}"
                            class="flex-1 border border-indigo-600 text-indigo-600 py-2 rounded-lg font-semibold hover:bg-indigo-50 transition text-center">
                            Lihat Keranjang
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="block text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>

        {{-- Ulasan --}}
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Ulasan Pembeli</h3>
            @if ($product->reviews->isEmpty())
                <p class="text-gray-400 text-sm">Belum ada ulasan untuk produk ini.</p>
            @else
                @foreach ($product->reviews as $review)
                    <div class="border-b pb-4 mb-4">
                        <p class="font-semibold text-gray-700">{{ $review->user->name }}</p>
                        <p class="text-yellow-500 text-sm">⭐ {{ $review->rating }}/5</p>
                        <p class="text-gray-600 text-sm mt-1">{{ $review->comment }}</p>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

</body>

</html>
