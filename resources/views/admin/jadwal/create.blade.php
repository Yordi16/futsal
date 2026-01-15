@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.jadwal.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kembali ke Daftar Jadwal</h2>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-slate-50/50 px-10 py-6 border-b border-slate-100 relative overflow-hidden">
                <i class="fas fa-calendar-plus absolute -right-4 -bottom-4 text-7xl text-slate-100"></i>
                <div class="relative z-10">
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                        <div class="p-2 bg-indigo-600 rounded-xl text-white shadow-lg shadow-indigo-200">
                            <i class="fas fa-clock"></i>
                        </div>
                        Tambah Slot Jadwal
                    </h1>
                    <p class="text-slate-500 text-sm mt-2.5">Tentukan jadwal operasional lapangan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.jadwal.store') }}" class="px-10 pt-6 pb-10 space-y-8">
                @csrf

                @error('jadwal')
                    <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-xl flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle text-rose-500"></i>
                        <p class="text-rose-700 text-xs font-bold uppercase tracking-wide">{{ $message }}</p>
                    </div>
                @enderror

                <div class="space-y-6">


                    <div class="space-y-2 relative">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                            <i class="fas fa-futbol text-indigo-500"></i> Pilih Lapangan
                        </label>
                        <div class="relative group">
                            <select name="lapangan_id"
                                class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:outline-none transition-all appearance-none cursor-pointer font-bold text-slate-700">
                                @foreach ($lapangans as $l)
                                    <option value="{{ $l->id }}" {{ old('lapangan_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama_lapangan }} ({{ $l->jenis }})
                                    </option>
                                @endforeach
                            </select>
                            <i
                                class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-hover:text-indigo-500 transition-colors"></i>
                        </div>
                        @error('lapangan_id')
                            <p class="absolute -bottom-5 left-2 text-rose-500 text-[10px] font-bold tracking-tight">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    <div class="space-y-2 relative">
                        <label
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-indigo-500"></i> Tanggal Main
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:outline-none transition-all font-bold text-slate-700"
                            min="{{ date('Y-m-d') }}" required>
                        @error('tanggal')
                            <p class="absolute -bottom-5 left-2 text-rose-500 text-[10px] font-bold tracking-tight">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-10">

                        <div class="space-y-2 relative">
                            <label
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                                <i class="fas fa-hourglass-start text-emerald-500"></i> Jam Mulai
                            </label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                class="w-full px-5 py-4 bg-emerald-50/30 border border-emerald-100 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all font-black text-emerald-700"
                                required>
                            @error('jam_mulai')
                                <p class="absolute -bottom-5 left-2 text-rose-500 text-[10px] font-bold tracking-tight">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="space-y-2 relative">
                            <label
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                                <i class="fas fa-hourglass-end text-rose-500"></i> Jam Selesai
                            </label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                                class="w-full px-5 py-4 bg-rose-50/30 border border-rose-100 rounded-2xl focus:ring-4 focus:ring-rose-100 focus:border-rose-500 focus:outline-none transition-all font-black text-rose-700"
                                required>
                            @error('jam_selesai')
                                <p class="absolute -bottom-5 left-2 text-rose-500 text-[10px] font-bold tracking-tight">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="pt-8 mt-4 flex items-center justify-between border-t border-slate-50">
                    <p class="text-[10px] text-slate-400 font-medium italic"></p>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.jadwal.index') }}"
                            class="px-6 py-3 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all uppercase tracking-widest">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all uppercase tracking-widest flex items-center gap-2">
                            Tambah Jadwal <i class="fas fa-check-circle"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection