@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <i class="fas fa-calendar-alt text-indigo-500"></i> Penjadwalan Lapangan
                </h1>
                <p class="text-slate-500 font-medium mt-1">Atur ketersediaan waktu untuk setiap lapangan futsal.</p>
            </div>

            <a href="{{ route('admin.jadwal.create') }}"
                class="flex items-center justify-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform active:scale-95">
                <i class="fas fa-plus"></i>
                Tambah Jadwal Baru
            </a>
        </div>

        {{-- TABLE CONTAINER --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Lapangan</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Sesi Waktu
                            </th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Status Slot
                            </th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($jadwals as $j)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-8 bg-indigo-500 rounded-full"></div>
                                        <span class="font-bold text-slate-700">{{ $j->lapangan->nama_lapangan }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d F Y') }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-4 py-2 bg-slate-100 rounded-xl text-slate-600 font-black tracking-tighter">
                                        <i class="far fa-clock mr-2 text-indigo-400"></i>
                                        {{ $j->jam_mulai }} - {{ $j->jam_selesai }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($j->status_slot == 'tersedia')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <i class="fas fa-door-open"></i> {{ $j->status_slot }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-full bg-rose-100 text-rose-700 border border-rose-200">
                                            <i class="fas fa-lock"></i> {{ $j->status_slot }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- EDIT --}}
                                        <a href="{{ route('admin.jadwal.edit', $j->id) }}"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>

                                        {{-- HAPUS --}}
                                        <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
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
                                        <i class="fas fa-calendar-times text-6xl mb-4 text-slate-300"></i>
                                        <p class="font-black uppercase tracking-[0.2em] text-sm text-slate-400">Belum ada jadwal
                                            yang diatur</p>
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