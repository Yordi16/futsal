<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Ari Futsal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-indigo-950 flex items-center justify-center p-4 md:p-6">

    <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] shadow-2xl w-full max-w-md p-6 md:p-10 transition-all">

        <div class="text-center mb-8 md:mb-10">

            <div
                class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-amber-400 text-indigo-900 rounded-2xl md:rounded-3xl shadow-lg shadow-amber-400/30 mb-4 transform -rotate-6">
                <i class="fas fa-futbol text-3xl md:text-5xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Ari<span
                    class="text-emerald-600">Futsal</span></h1>
            <p class="text-slate-500 text-xs md:text-sm font-medium mt-1">Sewa lapangan jadi lebih mudah</p>
        </div>

        @if ($errors->any())
            <div
                class="bg-rose-50 border border-rose-100 text-rose-600 text-[11px] md:text-sm rounded-xl p-4 mb-6 flex items-center gap-3">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-4 md:space-y-5">
            @csrf

            <div>
                <label class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Email
                    Address</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </span>
                    <input type="email" name="email" required
                        class="w-full pl-11 pr-4 py-3 md:py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400 text-sm md:text-base"
                        placeholder="Masukkan Email">
                </div>
            </div>

            <div>
                <label
                    class="text-[10px] md:text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Password</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required
                        class="w-full pl-11 pr-4 py-3 md:py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400 text-sm md:text-base"
                        placeholder="••••••••">
                </div>
            </div>


            <button type="submit"
                class="w-full bg-slate-900 hover:bg-emerald-600 text-white py-3.5 md:py-4 rounded-2xl font-black shadow-lg shadow-slate-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 text-sm md:text-base uppercase tracking-widest">
                Login <i class="fas fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <p class="text-center text-xs md:text-sm text-slate-500 mt-8 md:mt-10">
            Belum punya akun?
            <a href="/register" class="text-emerald-600 font-black hover:text-emerald-700 hover:underline transition">
                Daftar sekarang
            </a>
        </p>
    </div>

</body>

</html>