@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- BREADCRUMB / BACK BUTTON --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('lapangan.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kembali ke Daftar</h2>
        </div>

        {{-- CARD FORM --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            {{-- Header Card --}}
            <div class="bg-slate-50/50 px-10 py-8 border-b border-slate-100">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="p-2 bg-emerald-500 rounded-xl text-white shadow-lg shadow-emerald-200">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    Tambah Lapangan Baru
                </h1>
                <p class="text-slate-500 text-sm mt-1">Daftarkan lapangan baru ke dalam sistem FutsalHub.</p>
            </div>

            {{-- Form Body --}}
            <form action="{{ route('lapangan.store') }}" method="POST" class="p-10 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama Lapangan --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-tag text-emerald-500"></i> Nama Lapangan
                        </label>
                        <input type="text" name="nama_lapangan"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400"
                            placeholder="Contoh: Lapangan A" required>
                    </div>

                    {{-- Jenis --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-grass text-emerald-500"></i> Jenis Rumput/Lantai
                        </label>
                        <input type="text" name="jenis"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all placeholder:text-slate-400"
                            placeholder="Contoh: Rumput Sintetis" required>
                    </div>

                    {{-- Harga --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-emerald-500"></i> Harga per Jam
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400 font-bold text-sm">Rp</span>
                            <input type="number" name="harga_per_jam"
                                class="w-full pl-12 pr-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all"
                                placeholder="0" required>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-emerald-500"></i> Status Awal
                        </label>
                        <select name="status"
                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none transition-all appearance-none cursor-pointer text-slate-700">
                            <option value="tersedia">✅ Tersedia (Aktif)</option>
                            <option value="tidak tersedia">❌ Tidak Tersedia (Maintenance)</option>
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
                        class="px-10 py-3 bg-emerald-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-emerald-200 hover:bg-emerald-700 hover:-translate-y-1 transition-all uppercase tracking-widest flex items-center gap-2">
                        Simpan Lapangan <i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection