<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-indigo-600">TokoKu — Admin</h1>
        <div class="flex gap-4 items-center">
            <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:underline text-sm">Users</a>
            <a href="{{ route('admin.products') }}" class="text-indigo-600 hover:underline text-sm">Produk</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline text-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Admin Dashboard</h2>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 rounded-lg p-4 mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-500 text-sm">Total User</p>
                <h3 class="text-3xl font-bold text-indigo-600 mt-1">{{ $totalUsers }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-500 text-sm">Seller Aktif</p>
                <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $totalSellers }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-500 text-sm">Total Produk</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $totalProducts }}</h3>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-gray-500 text-sm">Total Order</p>
                <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ $totalOrders }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Order per Bulan</h3>
                <canvas id="orderChart"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Produk per Kategori</h3>
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pendaftaran Seller Menunggu Persetujuan</h3>

            @if ($pendingSellers->isEmpty())
                <p class="text-gray-400 text-sm">Tidak ada pendaftaran seller yang menunggu.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3">Nama User</th>
                            <th class="pb-3">Nama Toko</th>
                            <th class="pb-3">Deskripsi</th>
                            <th class="pb-3">Tanggal Daftar</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingSellers as $seller)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3">{{ $seller->user->name }}</td>
                                <td class="py-3">{{ $seller->store_name }}</td>
                                <td class="py-3 text-gray-500">{{ Str::limit($seller->description, 50) }}</td>
                                <td class="py-3 text-gray-500">{{ $seller->created_at->format('d M Y') }}</td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.seller.approve', $seller->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.seller.reject', $seller->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        const orderCtx = document.getElementById('orderChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'bar',
            data: {
                labels: @json($orderLabels),
                datasets: [{
                    label: 'Jumlah Order',
                    data: @json($orderData),
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    data: @json($categoryData),
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(34, 197, 94, 0.7)',
                        'rgba(251, 191, 36, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>

</html>
