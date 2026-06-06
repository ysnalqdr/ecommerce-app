<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-indigo-600">TokoKu — Admin</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:underline text-sm">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:underline text-sm">Users</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline text-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola Produk</h2>

        <div class="bg-white rounded-xl shadow p-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3">Nama Produk</th>
                        <th class="pb-3">Kategori</th>
                        <th class="pb-3">Harga</th>
                        <th class="pb-3">Stok</th>
                        <th class="pb-3">Seller</th>
                        <th class="pb-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $product->name }}</td>
                            <td class="py-3">{{ $product->category }}</td>
                            <td class="py-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-3">{{ $product->stock }}</td>
                            <td class="py-3">{{ $product->seller->store_name }}</td>
                            <td class="py-3 text-gray-500">{{ $product->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>