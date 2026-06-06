<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TokoKu</a>
        <div class="flex gap-4 items-center">
            @auth
                <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
                <a href="{{ route('cart.index') }}" class="text-indigo-600 hover:underline">Keranjang</a>
            @else
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
            @endauth
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Belanja</h2>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 rounded-lg p-4 mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="bg-white rounded-xl shadow p-10 text-center">
                <p class="text-gray-400 text-lg mb-4">Keranjang kamu masih kosong.</p>
                <a href="{{ route('home') }}"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Mulai Belanja</a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- Daftar Item --}}
                <div class="flex-1">
                    @foreach ($cartItems as $item)
                        <div class="bg-white rounded-xl shadow p-4 mb-4 flex gap-4 items-center">
                            {{-- Gambar --}}
                            <div
                                class="bg-gray-200 rounded-lg w-20 h-20 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-400 text-xs">No Image</span>
                            </div>

                            {{-- Info Produk --}}
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $item->product->name }}</h4>
                                <p class="text-indigo-600 font-bold">Rp
                                    {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                <p class="text-gray-400 text-sm">Qty: {{ $item->quantity }}</p>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right">
                                <p class="font-bold text-gray-800">Rp
                                    {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>

                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 text-sm hover:underline mt-2">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan --}}
                <div class="w-full lg:w-72">
                    <div class="bg-white rounded-xl shadow p-6">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Ringkasan Belanja</h3>
                        <div class="flex justify-between text-gray-600 mb-2">
                            <span>Total Item</span>
                            <span>{{ $cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-gray-800 text-lg border-t pt-4 mt-4">
                            <span>Total</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('order.checkout') }}"
                            class="block text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mt-6 transition">
                            Checkout
                        </a>
                        <a href="{{ route('home') }}"
                            class="block text-center text-indigo-600 hover:underline mt-3 text-sm">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>

            </div>
        @endif
    </div>

</body>

</html>
