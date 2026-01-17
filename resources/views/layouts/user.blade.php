<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ari Futsal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }


        .nav-item {
            transition: all 0.2s ease-in-out;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }


        #mobile-menu:not(.hidden) {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased">


    <nav class="bg-indigo-950 text-white px-5 md:px-8 py-3 md:py-4 sticky top-0 z-50 shadow-xl border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 md:w-10 md:h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 transform -rotate-6">
                    <i class="fas fa-futbol text-base md:text-lg"></i>
                </div>
                <span class="text-lg md:text-xl font-extrabold tracking-tighter uppercase">ARI<span
                        class="text-emerald-400">FUTSAL</span></span>
            </div>


            <div class="hidden md:flex gap-2 lg:gap-4 items-center">
                <a href="/user/dashboard"
                    class="nav-item px-4 py-2 rounded-xl text-[11px] lg:text-xs font-bold uppercase tracking-widest {{ request()->is('user/dashboard') ? 'bg-indigo-900 text-emerald-400 shadow-inner' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Dashboard
                </a>


                <a href="/user/lapangan"
                    class="nav-item px-4 py-2 rounded-xl text-[11px] lg:text-xs font-bold uppercase tracking-widest {{ request()->is('user/lapangan*') || request()->is('user/jadwal*') ? 'bg-indigo-900 text-emerald-400 shadow-inner' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Booking
                </a>

                <a href="/user/booking"
                    class="nav-item px-4 py-2 rounded-xl text-[11px] lg:text-xs font-bold uppercase tracking-widest {{ request()->is('user/booking*') ? 'bg-indigo-900 text-emerald-400 shadow-inner' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Riwayat
                </a>

                <div class="h-6 w-[1px] bg-white/10 mx-2"></div>

                <div class="flex items-center gap-4">
                    <span class="text-[12px] text-slate-400 lowercase italic font-medium">
                        Hi, {{ explode(' ', auth()->user()->name)[0] }}
                    </span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button
                            class="bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black transition-all border border-rose-500/20 uppercase tracking-widest">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button onclick="toggleMenu()" class="p-2 text-slate-300 hover:text-white focus:outline-none">
                    <i class="fas fa-bars text-xl" id="menu-icon"></i>
                </button>
            </div>
        </div>


        <div id="mobile-menu"
            class="hidden md:hidden absolute top-full left-0 w-full bg-indigo-950 border-t border-white/5 shadow-2xl">
            <div class="flex flex-col p-6 gap-2 text-[11px] font-bold uppercase tracking-widest">
                <a href="/user/dashboard"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('user/dashboard') ? 'bg-indigo-900 text-emerald-400' : 'text-slate-300' }}">
                    <i class="fas fa-th-large w-5 text-center"></i> Dashboard
                </a>


                <a href="/user/lapangan"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('user/lapangan*') || request()->is('user/jadwal*') ? 'bg-indigo-900 text-emerald-400' : 'text-slate-300' }}">
                    <i class="fas fa-calendar-plus w-5 text-center"></i> Booking
                </a>

                <a href="/user/booking"
                    class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('user/booking*') ? 'bg-indigo-900 text-emerald-400' : 'text-slate-300' }}">
                    <i class="fas fa-history w-5 text-center"></i> Riwayat
                </a>
                <hr class="border-white/5 my-2">
                <div class="flex items-center justify-between px-4 py-2">
                    <span class="text-xs text-slate-400 lowercase italic font-sans font-normal">Hi,
                        {{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button class="text-rose-400 font-extrabold text-[11px]">LOGOUT</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>


    <main class="max-w-7xl mx-auto p-4 md:p-8">
        <div
            class="bg-white rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-slate-200/60 p-5 md:p-8 min-h-[70vh]">
            @yield('content')
        </div>
    </main>


    <footer class="text-center py-10 text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">
        &copy; 2026 AriFutsal &bull; Booking System
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }
    </script>
</body>

</html>