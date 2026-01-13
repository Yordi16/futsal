@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- BREADCRUMB / BACK BUTTON --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('lapangan.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-amber-600 hover:border-amber-100 transition shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kembali ke Daftar</h2>
        </div>

        {{-- CARD FORM --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            {{-- Header Card --}}
            <div class="bg-slate-50/50 px-10 py-8 border-b border-slate-100">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="p-2 bg-amber-500 rounded-xl text-white shadow-lg shadow-amber-200">
                        <i class="fas fa-edit"></i>
                    </div>
                    Edit Data Lapangan
                </h1>
                <p class="text-slate-500 text-sm mt-1">Anda sedang mengubah informasi untuk <span
                        class="font-bold text-amber-600">{{ $lapangan->nama_lapangan }}</span>.</p>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('lapangan.update', $lapangan->id) }}" method="POST" class="p-10 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lapangan --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-tag text-amber-500"></i> Nama Lapangan
                        </label>
                        <input type="text" name="nama_lapangan" value="{{ $lapangan->nama_lapangan }}"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all font-bold text-slate-700"
                            required>
                    </div>

                    {{-- Jenis --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-grass text-amber-500"></i> Jenis Rumput/Lantai
                        </label>
                        <input type="text" name="jenis" value="{{ $lapangan->jenis }}"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all font-bold text-slate-700"
                            required>
                    </div>

                    {{-- Harga --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-amber-500"></i> Harga per Jam
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400 font-bold text-sm">Rp</span>
                            <input type="number" name="harga_per_jam" value="{{ $lapangan->harga_per_jam }}"
                                class="w-full pl-12 pr-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all font-bold text-slate-700"
                                required>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-amber-500"></i> Status Operasional
                        </label>
                        <select name="status"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all appearance-none cursor-pointer font-bold text-slate-700">
                            <option value="tersedia" {{ $lapangan->status == 'tersedia' ? 'selected' : '' }}>✅ Tersedia
                            </option>
                            <option value="tidak tersedia" {{ $lapangan->status == 'tidak tersedia' ? 'selected' : '' }}>❌
                                Tidak Tersedia</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 flex items-center justify-end gap-4 border-t border-slate-50 mt-8">
                    <a href="{{ route('lapangan.index') }}"
                        class="px-6 py-3 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all uppercase tracking-widest">
                        Batal
                    </a>

                    <button type="submit"
                        class="px-10 py-3 bg-slate-900 text-white rounded-2xl font-black text-sm shadow-xl shadow-slate-200 hover:bg-amber-600 hover:-translate-y-1 transition-all uppercase tracking-widest flex items-center gap-2">
                        Perbarui Data <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection