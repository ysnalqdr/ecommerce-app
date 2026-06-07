<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TokoKu — Belanja Mudah, Harga Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php use Illuminate\Support\Facades\Storage; @endphp
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Page load animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .hero-section { animation: fadeIn 0.6s ease forwards; }

        .product-card {
            animation: fadeUp 0.5s ease forwards;
            opacity: 0;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.1);
        }
        .product-card:active {
            transform: scale(0.97);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Staggered animation delay */
        .product-card:nth-child(1) { animation-delay: 0.05s; }
        .product-card:nth-child(2) { animation-delay: 0.1s; }
        .product-card:nth-child(3) { animation-delay: 0.15s; }
        .product-card:nth-child(4) { animation-delay: 0.2s; }
        .product-card:nth-child(5) { animation-delay: 0.25s; }
        .product-card:nth-child(6) { animation-delay: 0.3s; }
        .product-card:nth-child(7) { animation-delay: 0.35s; }
        .product-card:nth-child(8) { animation-delay: 0.4s; }
        .product-card:nth-child(9) { animation-delay: 0.45s; }
        .product-card:nth-child(10) { animation-delay: 0.5s; }
        .product-card:nth-child(11) { animation-delay: 0.55s; }
        .product-card:nth-child(12) { animation-delay: 0.6s; }

        .category-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        }

        .img-zoom img {
            transition: transform 0.4s ease;
        }
        .img-zoom:hover img {
            transform: scale(1.08);
        }

        .nav-dropdown:hover .nav-menu { display: block; }

        .badge-official {
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }
        .badge-local {
            background: linear-gradient(90deg, #10b981, #059669);
        }
        .flash-badge {
            background: linear-gradient(90deg, #ef4444, #f97316);
        }
        .hero-bg {
            background: linear-gradient(135deg, #f8faff 0%, #eef2ff 60%, #f3f4f6 100%);
        }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center gap-4 h-16">
                <a href="{{ route('home') }}" class="text-xl flex-shrink-0" style="font-weight:800">
                    Toko<span class="text-indigo-600">Ku</span>
                </a>
                <div class="flex-1 max-w-xl hidden sm:block">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk atau kategori..."
                            class="w-full bg-gray-100 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-3 ml-auto">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </a>
                        <div class="nav-dropdown relative">
                            <button class="flex items-center gap-2 bg-gray-100 hover:bg-indigo-50 px-3 py-2 rounded-xl transition text-sm font-medium text-gray-700">
                                <div class="w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div class="nav-menu hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-xs text-gray-400">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('order.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600">📦 Pesanan Saya</a>
                                @if(!auth()->user()->sellerProfile)
                                    <a href="{{ route('seller.register') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600">🏪 Jadi Seller</a>
                                @else
                                    <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600">🏪 Toko Saya</a>
                                @endif
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-indigo-600">⚙️ Admin Panel</a>
                                @endif
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50">🚪 Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
        <div class="sm:hidden px-4 pb-3">
            <input type="text" placeholder="Cari produk..."
                class="w-full bg-gray-100 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
    </nav>

    {{-- Hero --}}
    <div class="hero-bg hero-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14 sm:py-20">
            <div class="max-w-2xl">
                <span class="inline-block bg-indigo-100 text-indigo-600 text-xs font-semibold px-3 py-1 rounded-full mb-4">🛍️ Platform Belanja #1</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    Belanja Lebih <span class="text-indigo-600">Mudah</span>,<br>Harga Lebih <span class="text-indigo-600">Hemat</span>
                </h1>
                <p class="text-gray-500 text-lg mb-8 leading-relaxed">Temukan ribuan produk pilihan dari seller terpercaya di seluruh Indonesia.</p>
                <div class="flex gap-3">
                    <a href="#produk" class="bg-indigo-600 text-white font-semibold px-6 py-3 rounded-xl hover:bg-indigo-700 transition text-sm">Mulai Belanja</a>
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-xl border border-indigo-200 hover:bg-indigo-50 transition text-sm">Daftar Gratis</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Kategori</h2>
        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
            @foreach($categories as $category)
                <a href="#produk" class="category-card flex flex-col items-center gap-2 bg-white rounded-2xl p-3 border border-gray-100">
                    <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center text-xl">
                        @if(str_contains(strtolower($category), 'fashion') || str_contains(strtolower($category), 'baju') || str_contains(strtolower($category), 'kaos'))👕
                        @elseif(str_contains(strtolower($category), 'sepatu'))👟
                        @elseif(str_contains(strtolower($category), 'tas'))👜
                        @elseif(str_contains(strtolower($category), 'elektronik'))📱
                        @elseif(str_contains(strtolower($category), 'aksesoris'))⌚
                        @else🛒
                        @endif
                    </div>
                    <span class="text-xs text-gray-600 text-center font-medium leading-tight">{{ $category }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Flash Sale --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center gap-3 mb-5">
                <span class="flash-badge text-white text-xs font-bold px-3 py-1.5 rounded-lg">⚡ FLASH SALE</span>
                <span class="text-sm text-gray-400">Harga terbaik hari ini</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-3">
                @foreach($flashSale as $product)
                    <a href="{{ route('product.show', $product->id) }}" class="product-card block group bg-white rounded-xl border border-gray-100 overflow-hidden">
                        <div class="relative img-zoom h-28 overflow-hidden bg-gray-50">
                            @if($product->discount_percent > 0)
                                <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-md z-10">-{{ $product->discount_percent }}%</span>
                            @endif
                            @if($product->primaryImage)
                                <img src="{{ Storage::url($product->primaryImage->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">No Image</div>
                            @endif
                        </div>
                        <div class="p-2">
                            <p class="text-xs text-gray-800 truncate font-medium">{{ $product->name }}</p>
                            <p class="text-xs text-red-500 font-bold mt-0.5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->original_price)
                                <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Rekomendasi --}}
    @auth
        @if($recommendations->isNotEmpty())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center gap-2 mb-5">
                        <span class="text-lg">🎯</span>
                        <h2 class="text-lg font-bold text-gray-900">Rekomendasi Untukmu</h2>
                        <span class="text-xs text-gray-400 ml-1">Berdasarkan riwayat browsing kamu</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-8 gap-3">
                        @foreach($recommendations as $product)
                            <a href="{{ route('product.show', $product->id) }}" class="product-card block group bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <div class="relative img-zoom h-28 overflow-hidden bg-gray-50">
                                    {{-- Discount Badge --}}
                                    @if($product->discount_percent > 0)
                                        <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-md z-10">-{{ $product->discount_percent }}%</span>
                                    @endif
                                    {{-- Store Badge --}}
                                    @if($product->badge === 'official')
                                        <span class="absolute top-1.5 left-1.5 badge-official text-white text-xs font-bold px-1.5 py-0.5 rounded-md z-10">Mall</span>
                                    @elseif($product->badge === 'local')
                                        <span class="absolute top-1.5 left-1.5 badge-local text-white text-xs font-bold px-1.5 py-0.5 rounded-md z-10">Lokal</span>
                                    @endif
                                    @if($product->primaryImage)
                                        <img src="{{ Storage::url($product->primaryImage->image_url) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">No Image</div>
                                    @endif
                                </div>
                                <div class="p-2">
                                    <p class="text-xs text-gray-800 truncate font-medium">{{ $product->name }}</p>
                                    <p class="text-xs text-indigo-600 font-bold mt-0.5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @if($product->original_price)
                                        <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                    @endif
                                    @if($product->total_sold > 0)
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $product->total_sold >= 1000 ? number_format($product->total_sold/1000, 1).'rb' : $product->total_sold }} terjual
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endauth

    {{-- Semua Produk --}}
    <div id="produk" class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Produk Terbaru</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-card bg-white rounded-2xl border border-gray-100 overflow-hidden block group">
                    <div class="relative img-zoom h-40 overflow-hidden bg-gray-50">
                        {{-- Discount Badge --}}
                        @if($product->discount_percent > 0)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-md z-10">-{{ $product->discount_percent }}%</span>
                        @endif
                        {{-- Store Badge --}}
                        @if($product->badge === 'official')
                            <span class="absolute top-2 left-2 badge-official text-white text-xs font-bold px-2 py-0.5 rounded-md z-10">Mall</span>
                        @elseif($product->badge === 'local')
                            <span class="absolute top-2 left-2 badge-local text-white text-xs font-bold px-2 py-0.5 rounded-md z-10">Lokal</span>
                        @endif
                        @if($product->primaryImage)
                            <img src="{{ Storage::url($product->primaryImage->image_url) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">No Image</div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h4 class="text-xs font-semibold text-gray-800 truncate">{{ $product->name }}</h4>
                        <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                            <p class="text-sm font-bold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->original_price)
                                <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                        @if($product->total_sold > 0)
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $product->total_sold >= 1000 ? number_format($product->total_sold/1000, 1).'rb' : $product->total_sold }} terjual
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 mb-10">
                <div class="col-span-2 sm:col-span-1">
                    <p class="text-xl font-extrabold text-gray-900 mb-3">Toko<span class="text-indigo-600">Ku</span></p>
                    <p class="text-sm text-gray-400 leading-relaxed">Platform belanja online terpercaya dengan ribuan produk pilihan dari seller terbaik.</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 mb-4">Layanan</p>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Bantuan</a></li>
                        <li><a href="{{ route('order.index') }}" class="text-sm text-gray-400 hover:text-indigo-600 transition">Lacak Pesanan</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Pengembalian</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 mb-4">Jual di TokoKu</p>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('seller.register') }}" class="text-sm text-gray-400 hover:text-indigo-600 transition">Daftar Seller</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Panduan Seller</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 mb-4">Ikuti Kami</p>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Instagram</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Twitter</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-indigo-600 transition">Facebook</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p class="text-xs text-gray-400">© {{ date('Y') }} TokoKu. All rights reserved.</p>
                <p class="text-xs text-gray-400">Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

</body>
</html>