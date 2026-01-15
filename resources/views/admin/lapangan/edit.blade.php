@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center gap-2">
            <a href="{{ route('lapangan.index') }}"
                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-amber-600 hover:border-amber-100 transition shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kembali ke Daftar Lapangan</h2>
        </div>


        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">

            <div class="bg-slate-50/50 px-10 py-8 border-b border-slate-100">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="p-2 bg-amber-500 rounded-xl text-white shadow-lg shadow-amber-200">
                        <i class="fas fa-edit"></i>
                    </div>
                    Edit Data Lapangan
                </h1>
                <p class="text-slate-500 text-sm mt-3">Anda sedang mengubah informasi untuk <span
                        class="font-bold text-amber-600">{{ $lapangan->nama_lapangan }}</span>.</p>
            </div>


            <form action="{{ route('lapangan.update', $lapangan->id) }}" method="POST" class="p-10 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-tag text-amber-500"></i> Nama Lapangan
                        </label>


                        <input type="text" name="nama_lapangan"
                            value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}"
                            class="w-full px-5 py-3 bg-slate-50 border @error('nama_lapangan') border-rose-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all font-bold text-slate-700"
                            required>


                        @error('nama_lapangan')
                            <p class="text-rose-500 text-[10px] font-bold italic mt-1 ml-2 uppercase tracking-wider">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <i class="fas fa-grass text-amber-500"></i> Jenis Lapangan
                        </label>
                        <div class="relative">
                            <select name="jenis" required
                                class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 focus:outline-none transition-all appearance-none cursor-pointer text-slate-700">
                                <option value="Rumput Sintetis"
                                    {{ $lapangan->jenis == 'Rumput Sintetis' ? 'selected' : '' }}>
                                    Rumput Sintetis</option>
                                <option value="Vinyl" {{ $lapangan->jenis == 'Vinyl' ? 'selected' : '' }}>Vinyl</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

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
