<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Futsal Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="p-6">
                <h1 class="text-2xl font-bold tracking-wider flex items-center">
                    <i class="fas fa-futbol mr-3 text-blue-400"></i>FUTSAL
                </h1>
            </div>

            <nav class="flex-1 px-4 space-y-2">
                <a href="/dashboard" class="flex items-center p-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ url('/user/booking') }}" class="flex items-center p-3 text-gray-300 hover:bg-slate-800 hover:text-white rounded-lg transition">
                    <i class="fas fa-calendar-plus w-6"></i>
                    <span>Booking Lapangan</span>
                </a>

                <a href="{{ url('/user/booking/history') }}" class="flex items-center p-3 text-white bg-blue-600 rounded-lg transition">
                    <i class="fas fa-history w-6"></i>
                    <span>Riwayat Booking</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <button class="flex items-center w-full p-3 text-gray-400 hover:text-red-400 transition">
                    <i class="fas fa-sign-out-alt w-6"></i>
                    <span>Logout</span>
                </button>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 bg-gray-50">
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <div class="md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </div>
                <div class="hidden md:block text-sm text-gray-500">
                    Selamat Datang, <span class="font-semibold text-gray-700 underline">User</span>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                    U
                </div>
            </header>

            <div class="p-4 md:p-8">
                {{-- Gunakan w-full di sini agar konten mengisi seluruh sisa layar --}}
                <div class="w-full max-w-[1400px] mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

</body>

</html>