<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Akun | Ari Futsal</title>
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

    <div class="bg-white/95 backdrop-blur-md rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 my-10">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-amber-400 text-indigo-900 rounded-2xl shadow-lg shadow-amber-400/30 mb-4 transform rotate-3">
                <i class="fas fa-user-plus fa-2xl"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Buat <span
                    class="text-emerald-600">Akun</span></h1>
            <p class="text-slate-500 font-medium mt-1">Bergabunglah dengan komunitas AriFutsal</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-100 text-rose-600 text-sm rounded-2xl p-4 mb-6">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <i class="fas fa-circle-exclamation text-xs"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="/register" class="space-y-4">
            @csrf

            <div>
                <label class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 ml-1">Username</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-user text-sm"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-300 text-sm"
                        placeholder="Masukkan Username">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 ml-1">Email
                    Address</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-envelope text-sm"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-300 text-sm"
                        placeholder="Masukkan Email">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 ml-1">Password</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-300 text-sm"
                        placeholder="Minimal 6 karakter">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-[0.15em] text-slate-400 ml-1">Konfirmasi
                    Password</label>
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i class="fas fa-check-double text-sm"></i>
                    </span>
                    <input type="password" name="password_confirmation" required
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-300 text-sm"
                        placeholder="Ulangi password anda">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-slate-900 hover:bg-emerald-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-slate-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 mt-4">
                DAFTAR SEKARANG <i class="fas fa-paper-plane"></i>
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-8">
            Sudah punya akun?
            <a href="/login" class="text-emerald-600 font-bold hover:text-emerald-700 hover:underline transition">
                Masuk di sini
            </a>
        </p>
    </div>

</body>

</html>