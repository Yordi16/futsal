@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <i class="fas fa-layer-group text-indigo-500"></i> Manajemen Lapangan
                </h1>
                <p class="text-slate-500 font-medium mt-1">Kelola daftar lapangan futsal yang tersedia di sistem.</p>
            </div>

            <a href="{{ route('lapangan.create') }}"
                class="flex items-center justify-center gap-3 px-6 py-3 bg-emerald-600 text-white rounded-2xl font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all transform active:scale-95">
                <i class="fas fa-plus"></i>
                Tambah Lapangan
            </a>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Info Lapangan
                            </th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Jenis Rumput
                            </th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Harga Sewa
                            </th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse ($lapangans as $l)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                            {{ substr($l->nama_lapangan, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 tracking-tight">{{ $l->nama_lapangan }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID:
                                                #LAP-0{{ $l->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span
                                        class="px-4 py-1.5 rounded-xl bg-slate-100 text-slate-600 font-bold text-xs uppercase italic tracking-tighter">
                                        {{ $l->jenis }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="text-indigo-600 font-black">
                                        Rp {{ number_format($l->harga_per_jam, 0, ',', '.') }}
                                        <span class="text-[10px] text-slate-400 font-normal">/jam</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($l->status == 'tersedia')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm shadow-emerald-100">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-100 text-rose-700 border border-rose-200 shadow-sm shadow-rose-100">
                                            <i class="fas fa-times-circle"></i> Sibuk
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- EDIT --}}
                                        <a href="{{ route('lapangan.edit', $l->id) }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                            title="Edit Lapangan">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('lapangan.destroy', $l->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all shadow-sm"
                                                title="Hapus Lapangan">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <i class="fas fa-layer-group text-6xl mb-4"></i>
                                        <p class="font-black uppercase tracking-[0.2em] text-sm text-slate-400">Data lapangan
                                            belum tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection