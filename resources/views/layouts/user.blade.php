<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ari Futsal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: #fbbf24;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-active::after {
            width: 100%;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <nav class="bg-indigo-950 text-white px-8 py-5 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 transform -rotate-6">
                    <i class="fas fa-futbol fa-lg"></i>
                </div>
                <span class="text-xl font-black tracking-tighter">ARI<span class="text-emerald-400">FUTSAL</span></span>
            </div>

            {{-- Menu Links --}}
            <div class="hidden md:flex gap-8 text-sm font-bold uppercase tracking-widest items-center">
                <a href="/user/dashboard"
                    class="nav-link {{ request()->is('user/dashboard') ? 'nav-active text-emerald-400' : 'text-slate-300 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="/user/lapangan"
                    class="nav-link {{ request()->is('user/lapangan*') ? 'nav-active text-emerald-400' : 'text-slate-300 hover:text-white' }}">
                    Pesan Lapangan
                </a>
                <a href="/user/booking"
                    class="nav-link {{ request()->is('user/booking*') ? 'nav-active text-emerald-400' : 'text-slate-300 hover:text-white' }}">
                    Booking Jadwal
                </a>

                <div class="h-6 w-[1px] bg-white/20 ml-2"></div>

                {{-- User Profile & Logout --}}
                <div class="flex items-center gap-4 ml-2">
                    <span class="text-[10px] text-slate-400 lowercase italic font-normal">Hi,
                        {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button
                            class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-[10px] font-black transition-all shadow-lg shadow-rose-500/20">
                            LOGOUT
                        </button>
                    </form>
                </div>
            </div>

            {{-- Mobile Menu Icon (Placeholder) --}}
            <div class="md:hidden text-2xl">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <div class="bg-indigo-900 px-8 py-10 text-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-black italic uppercase tracking-tighter">@yield('page_title', 'Selamat Datang')
            </h2>
            <p class="text-indigo-300 text-sm mt-1">Kelola pesanan dan jadwal olahraga Anda di sini.</p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto p-8 -mt-8">
        <div class="bg-white rounded-[2.5rem] shadow-xl p-8 min-h-[60vh] border border-slate-100">
            @yield('content')
        </div>
    </main>

    <footer class="text-center py-10 text-slate-400 text-xs font-medium uppercase tracking-[0.2em]">
        &copy; 2026 FutsalHub Booking System — Built for Excellence
    </footer>

</body>

</html>