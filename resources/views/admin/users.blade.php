<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-indigo-600">TokoKu — Admin</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:underline text-sm">Dashboard</a>
            <a href="{{ route('admin.products') }}" class="text-indigo-600 hover:underline text-sm">Produk</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:underline text-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelola User</h2>

        <div class="bg-white rounded-xl shadow p-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-3">Nama</th>
                        <th class="pb-3">Email</th>
                        <th class="pb-3">Role</th>
                        <th class="pb-3">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $user->name }}</td>
                            <td class="py-3">{{ $user->email }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($user->role === 'admin') bg-red-100 text-red-600
                                    @elseif($user->role === 'seller') bg-blue-100 text-blue-600
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>