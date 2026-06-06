<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TokoKu</a>
        <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pesanan</h2>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 rounded-lg p-4 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white rounded-xl shadow p-10 text-center">
                <p class="text-gray-400 text-lg mb-4">Kamu belum punya pesanan.</p>
                <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Mulai Belanja</a>
            </div>
        @else
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow p-6 mb-4">

                    {{-- Header Order --}}
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-gray-400">Order #{{ $order->id }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-600
                            @elseif($order->status === 'paid') bg-blue-100 text-blue-600
                            @elseif($order->status === 'delivered') bg-green-100 text-green-600
                            @else bg-gray-100 text-gray-600
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- Item List --}}
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach

                    {{-- Total --}}
                    <div class="border-t pt-4 mt-4 flex justify-between font-bold text-gray-800">
                        <span>Total</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                </div>
            @endforeach
        @endif
    </div>

</body>
</html>