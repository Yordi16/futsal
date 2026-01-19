@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6" x-data="{ tab: 'manual' }">


        <div class="flex items-center gap-2 group">
            <a href="{{ route('admin.jadwal.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-100 transition-all shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kembali ke Daftar Jadwal</h2>
        </div>


        @if (session('success'))
            <div x-data="{ show: true }" x-show="show"
                class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl flex items-center justify-between shadow-sm shadow-emerald-100/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <i class="fas fa-check-circle text-xs"></i>
                    </div>
                    <p class="text-emerald-700 text-xs font-black uppercase tracking-wide">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 px-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif


        @if (session('error'))
            <div x-data="{ show: true }" x-show="show"
                class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-2xl flex items-center justify-between shadow-sm shadow-rose-100/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-rose-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <i class="fas fa-exclamation-circle text-xs"></i>
                    </div>
                    <p class="text-rose-700 text-xs font-black uppercase tracking-wide">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-rose-600 px-2">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">


            <div class="bg-slate-50/50 px-10 py-8 border-b border-slate-100 relative overflow-hidden">
                <i class="fas fa-calendar-plus absolute -right-4 -bottom-4 text-8xl text-slate-100/50 rotate-12"></i>
                <div class="relative z-10">
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-200 flex items-center justify-center">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        Tambah Slot Jadwal
                    </h1>
                    <p class="text-slate-500 text-sm mt-3 font-medium">Atur ketersediaan slot lapangan dengan presisi.</p>
                </div>


                <div class="flex bg-slate-200/60 p-1.5 rounded-2xl mt-8 w-fit relative z-10 border border-slate-200/50">
                    <button @click="tab = 'manual'" :class="tab === 'manual' ? 'bg-white text-indigo-600 shadow-md' :
                                                'text-slate-500 hover:text-slate-700'"
                        class="px-8 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-[0.15em]">
                        Manual
                    </button>
                    <button @click="tab = 'auto'" :class="tab === 'auto' ? 'bg-white text-emerald-600 shadow-md' :
                                                'text-slate-500 hover:text-slate-700'"
                        class="px-8 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-[0.15em] flex items-center gap-2">
                        Otomatis
                    </button>
                </div>
            </div>


            <form x-show="tab === 'manual'" method="POST" action="{{ route('admin.jadwal.store') }}"
                class="px-10 py-10 space-y-8">
                @csrf
                <div class="space-y-6">
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2 ml-1">
                            <i class="fas fa-futbol text-indigo-500"></i> Pilih Lapangan
                        </label>
                        <select name="lapangan_id"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none font-bold text-slate-700 appearance-none shadow-sm">
                            @foreach ($lapangans as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lapangan }} ({{ $l->jenis }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2 ml-1">
                            <i class="fas fa-calendar-day text-indigo-500"></i> Tanggal Main
                        </label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none font-bold text-slate-700 shadow-sm"
                            min="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Jam
                                Mulai</label>
                            <input type="time" name="jam_mulai"
                                class="w-full px-6 py-4 bg-emerald-50/30 border border-emerald-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-black text-emerald-700 shadow-sm"
                                required>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Jam
                                Selesai</label>
                            <input type="time" name="jam_selesai"
                                class="w-full px-6 py-4 bg-rose-50/30 border border-rose-100 rounded-2xl focus:ring-4 focus:ring-rose-100 focus:border-rose-500 outline-none font-black text-rose-700 shadow-sm"
                                required>
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex items-center justify-end border-t border-slate-50">

                    <button type="submit"
                        class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all uppercase tracking-[0.2em] flex items-center gap-3">
                        Tambah Jadwal
                    </button>
                </div>
            </form>


            <form x-show="tab === 'auto'" x-cloak method="POST" action="{{ route('admin.jadwal.generate') }}"
                class="px-10 py-10 space-y-8">
                @csrf
                <div class="space-y-6">

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2 ml-1">
                            <i class="fas fa-futbol text-emerald-500"></i> Pilih Lapangan
                        </label>
                        <select name="lapangan_id"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-bold text-slate-700 appearance-none shadow-sm">
                            @foreach ($lapangans as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_lapangan }} ({{ $l->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2 ml-1">
                            <i class="fas fa-calendar-alt text-emerald-500"></i> Tanggal
                        </label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-bold text-slate-700 shadow-sm"
                            required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Jam
                                Buka</label>
                            <input type="time" name="jam_buka" value="08:00"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-bold text-slate-700 shadow-sm"
                                required>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 ml-1">Jam
                                Tutup</label>
                            <input type="time" name="jam_tutup" value="23:00"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-bold text-slate-700 shadow-sm"
                                required>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-2 ml-1">
                            <i class="fas fa-hourglass-half text-emerald-500"></i> Durasi Per Jam
                        </label>
                        <div class="relative">
                            <input type="number" name="durasi" value="1" min="1"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 outline-none font-black text-slate-700 shadow-sm"
                                required>
                            <span
                                class="absolute right-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Jam</span>
                        </div>
                    </div>
                </div>

                <div class="pt-8 flex items-center justify-end border-t border-slate-50">
                    <button type="submit"
                        class="px-10 py-4 bg-emerald-600 text-white rounded-2xl font-black text-xs shadow-xl shadow-emerald-200 hover:bg-emerald-700 transition-all uppercase tracking-[0.2em] flex items-center gap-3">
                        Tambah Jadwal Otomatis
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection