<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>

<body class="bg-gray-100">

    {{-- Navbar --}}
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TokoKu</a>
        <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
    </nav>

    <div class="max-w-xl mx-auto px-4 py-10">
        <div class="bg-white rounded-xl shadow p-8 text-center">

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selesaikan Pembayaran</h2>
                <p class="text-gray-500 text-sm">Order #{{ $order->id }}</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                @foreach ($order->orderItems as $item)
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->price_snapshot * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="border-t pt-3 mt-3 flex justify-between font-bold text-gray-800">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <button id="pay-button"
                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition text-lg">
                Bayar Sekarang
            </button>

            <a href="{{ route('order.index') }}" class="block text-center text-gray-400 hover:underline mt-4 text-sm">
                Lihat Riwayat Pesanan
            </a>

        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('order.index') }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route('order.index') }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function() {
                    alert('Kamu menutup popup pembayaran sebelum menyelesaikan transaksi.');
                }
            });
        };
    </script>

</body>

</html>
