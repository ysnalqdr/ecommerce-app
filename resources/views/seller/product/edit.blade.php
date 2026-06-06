<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('seller.dashboard') }}" class="text-xl font-bold text-indigo-600">TokoKu — Seller</a>
        <span class="text-gray-600">{{ Auth::user()->name }}</span>
    </nav>

    <div class="max-w-2xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk</h2>

        <div class="bg-white rounded-xl shadow p-6">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 mb-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Gambar yang sudah ada --}}
                @if($product->images->isNotEmpty())
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Saat Ini</label>
                        <div class="flex gap-2 flex-wrap">
                            @foreach($product->images as $image)
                                <img src="{{ Storage::url($image->image_url) }}"
                                    class="w-20 h-20 object-cover rounded-lg border">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Baru</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Update Produk
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="flex-1 border border-gray-300 text-gray-600 py-2 rounded-lg font-semibold hover:bg-gray-50 transition text-center">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>