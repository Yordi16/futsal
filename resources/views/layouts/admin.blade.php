<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel | AriFutsal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-72 bg-indigo-950 text-slate-100 flex flex-col shadow-2xl fixed inset-y-0 left-0 z-50">

            <div class="p-8 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center text-indigo-950 shadow-lg shadow-amber-400/20">
                        <i class="fas fa-futbol fa-lg"></i>
                    </div>
                    <h1 class="text-xl font-black tracking-tight text-white">
                        Ari<span class="text-amber-400">Futsal</span>
                    </h1>
                </div>
            </div>

            <nav
                class="flex-1 p-6 space-y-2 overflow-y-auto custom-scroll text-sm font-semibold uppercase tracking-wider">
                @php
                    $menu = function ($patterns) {
                        foreach ((array) $patterns as $pattern) {
                            if (request()->is($pattern)) {
                                return 'bg-white/10 text-white border-l-4 border-amber-400 pl-3';
                            }
                        }
                        return 'text-slate-400 hover:bg-white/5 hover:text-white pl-4 transition-all duration-200';
                    };
                @endphp

                <a href="/admin/dashboard"
                    class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/dashboard']) }}">
                    <i
                        class="fas fa-chart-pie w-5 text-center {{ request()->is('admin/dashboard') ? 'text-amber-400' : '' }}"></i>
                    Dashboard
                </a>

                <a href="{{ route('lapangan.index') }}"
                    class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/lapangan*']) }}">
                    <i
                        class="fas fa-layer-group w-5 text-center {{ request()->is('admin/lapangan*') ? 'text-amber-400' : '' }}"></i>
                    Kelola Lapangan
                </a>

                <a href="/admin/jadwal" class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/jadwal*']) }}">
                    <i
                        class="fas fa-calendar-alt w-5 text-center {{ request()->is('admin/jadwal*') ? 'text-amber-400' : '' }}"></i>
                    Kelola Jadwal
                </a>

                <a href="/admin/booking"
                    class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/booking*']) }}">
                    <i
                        class="fas fa-ticket-alt w-5 text-center {{ request()->is('admin/booking*') ? 'text-amber-400' : '' }}"></i>
                    Kelola Booking
                </a>
                
                <a href="{{ route('admin.daftaruser.index') }}"
                    class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/daftar-user*']) }}">
                    <i class="fas fa-users w-5 text-center {{ request()->is('admin/daftar-user*') ? 'text-amber-400' : '' }}"></i>
                    Kelola User
                </a>

                <a href="/admin/report" class="flex items-center gap-4 py-3 rounded-xl {{ $menu(['admin/report*']) }}">
                    <i
                        class="fas fa-file-invoice-dollar w-5 text-center {{ request()->is('admin/report*') ? 'text-amber-400' : '' }}"></i>
                    Laporan
                </a>
            </nav>


            <div class="p-6 border-t border-white/10">
                <form action="/logout" method="POST">
                    @csrf
                    <button
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white transition-all duration-300 font-bold text-xs uppercase tracking-widest">
                        <i class="fas fa-sign-out-alt"></i> Logout Akun
                    </button>
                </form>
            </div>
        </aside>


        <main class="flex-1 ml-72 overflow-y-auto bg-slate-50 no-scrollbar">

            <header class="h-20 flex items-center justify-end px-10">
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest">Administrator</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="px-10 pb-10">
                <div class="bg-white rounded-[2rem] shadow-sm p-8 min-h-[80vh] border border-slate-100">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>