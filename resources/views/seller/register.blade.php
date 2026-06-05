<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jadi Seller</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow p-8 w-full max-w-md">

        {{-- Header --}}
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Jadi Seller</h2>
            <p class="text-gray-500 text-sm mt-1">Isi data toko kamu untuk mulai berjualan</p>
        </div>

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('seller.store') }}">
            @csrf

            {{-- Nama Toko --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                <input type="text" name="store_name" value="{{ old('store_name') }}"
                    placeholder="Contoh: Toko Elektronik Jaya"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Toko <span
                        class="text-gray-400">(opsional)</span></label>
                <textarea name="description" rows="4" placeholder="Ceritakan tentang toko kamu..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Daftar Sekarang
            </button>

        </form>

        {{-- Back --}}
        <p class="text-center text-sm text-gray-500 mt-4">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">← Kembali ke Beranda</a>
        </p>

    </div>

</body>

</html>
