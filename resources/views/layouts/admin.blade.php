<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            ADMIN FUTSAL
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Dashboard
            </a>

            <a href="{{ route('lapangan.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
                Lapangan
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700">
            {{-- <form action="{{ route('logout') }}" method="POST"> --}}
                @csrf
                <button class="w-full bg-red-600 py-2 rounded hover:bg-red-700">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-6">
        <div class="bg-white p-6 rounded shadow">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
