<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Futsal Hub</title>
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

<body
    class="min-h-screen bg-gradient-to-br from-emerald-600 via-green-600 to-indigo-800 flex items-center justify-center p-4">

    <div class="bg-white/95 backdrop-blur-md rounded-[2rem] shadow-2xl w-full max-w-md p-10">
        {{-- Header --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-amber-400 text-indigo-900 rounded-3xl shadow-lg shadow-amber-400/30 mb-4 transform -rotate-6">
                <i class="fas fa-futbol fa-3x"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Futsal<span
                    class="text-emerald-600">Hub</span></h1>
            <p class="text-slate-500 font-medium mt-1">Sewa lapangan jadi lebih mudah</p>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div
                class="bg-rose-50 border border-rose-100 text-rose-600 text-sm rounded-xl p-4 mb-6 flex items-center gap-3">
                <i class="fas fa-circle-exclamation"></i>
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="/login" class="space-y-5">
            @csrf

            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Email Address</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400"
                        placeholder="email@example.com">
                </div>
            </div>

            <div>
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Password</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-slate-900 hover:bg-emerald-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-slate-200 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                Login <i class="fas fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        {{-- Footer --}}
        <p class="text-center text-sm text-slate-500 mt-10">
            Belum punya akun?
            <a href="/register" class="text-emerald-600 font-bold hover:text-emerald-700 hover:underline transition">
                Daftar sekarang
            </a>
        </p>
    </div>

</body>

</html>