<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600">TokoKu — Seller</h1>
        <div class="flex gap-4 items-center">
            <span class="text-gray-600">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- Greeting --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, {{ $seller->store_name }}! 👋</h2>
        <p class="text-gray-500 mb-8">Selamat datang di dashboard toko kamu.</p>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500 text-sm">Total Produk</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-1">{{ $totalProducts }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500 text-sm">Total Stok</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-1">{{ $totalStock }}</h3>
            </div>
        </div>

        {{-- Daftar Produk --}}
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Produk Kamu</h3>
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">+
                    Tambah Produk</a>
            </div>

            @if ($products->isEmpty())
                <p class="text-gray-400">Belum ada produk. Mulai tambahkan produk kamu!</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3">Nama Produk</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Stok</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3">{{ $product->name }}</td>
                                <td class="py-3">{{ $product->category }}</td>
                                <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="py-3">{{ $product->stock }}</td>
                                <td class="py-3 flex gap-2">
                                    <a href="#" class="text-indigo-600 hover:underline">Edit</a>
                                    <a href="#" class="text-red-500 hover:underline">Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>

</body>

</html>
