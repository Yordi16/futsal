@extends('layouts.user')

@section('page_title', 'Dashboard User')

@section('content')
<div class="space-y-8">
    {{-- Welcome Message --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-2xl font-black text-slate-800">Halo, {{ auth()->user()->name }}! 👋</h3>
            <p class="text-slate-500 font-medium">Berikut adalah ringkasan aktivitas booking Anda.</p>
        </div>
        <a href="/user/lapangan" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-emerald-500/20 uppercase tracking-widest">
            Main Sekarang
        </a>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Booking Aktif --}}
        <div class="bg-indigo-50 p-6 rounded-[2rem] border border-indigo-100 relative overflow-hidden group">
            <i class="fas fa-calendar-check absolute -right-4 -bottom-4 text-6xl text-indigo-200 group-hover:scale-110 transition-transform"></i>
            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-1">Booking Mendatang</p>
            <h4 class="text-3xl font-black text-indigo-900">{{ $upcomingCount }}</h4>
            <p class="text-xs text-indigo-600 font-bold mt-1 uppercase">Jadwal Menanti</p>
        </div>

        {{-- Total Transaksi --}}
        <div class="bg-emerald-50 p-6 rounded-[2rem] border border-emerald-100 relative overflow-hidden group">
            <i class="fas fa-history absolute -right-4 -bottom-4 text-6xl text-emerald-200 group-hover:scale-110 transition-transform"></i>
            <p class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Total Main</p>
            <h4 class="text-3xl font-black text-emerald-900">{{ $totalMainCount }}</h4>
            <p class="text-xs text-emerald-600 font-bold mt-1 uppercase">Pertandingan Selesai</p>
        </div>

        {{-- Status Member --}}
        <div class="bg-amber-50 p-6 rounded-[2rem] border border-amber-100 relative overflow-hidden group">
            <i class="fas fa-medal absolute -right-4 -bottom-4 text-6xl text-amber-200 group-hover:scale-110 transition-transform"></i>
            <p class="text-[10px] font-black uppercase tracking-widest text-amber-400 mb-1">Status Akun</p>
            <h4 class="text-3xl font-black text-amber-900">Reguler</h4>
            <p class="text-xs text-amber-600 font-bold mt-1 uppercase">Pemain Aktif</p>
        </div>
    </div>

    {{-- Recent Booking Table --}}
    <div class="mt-10">
        <h3 class="text-lg font-black text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-ticket-alt text-emerald-500"></i> Booking Terbaru Anda
        </h3>
        <div class="overflow-hidden border border-slate-100 rounded-3xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4">Lapangan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $b)
                    <tr class="hover:bg-slate-50/50 transition-all">
                        <td class="px-6 py-4 font-bold text-slate-700">
                            {{-- Null-safe untuk nama lapangan --}}
                            {{ $b->jadwalLapangan?->lapangan?->nama_lapangan ?? 'Lapangan' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                {{-- Format Tanggal Indonesia --}}
                                <span class="text-sm font-bold text-slate-600">
                                    {{ $b->jadwalLapangan? \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->translatedFormat('d F Y') : 'N/A' }}
                                </span>
                                {{-- Null-safe untuk Jam --}}
                                <span class="text-[10px] text-emerald-500 font-black">
                                    {{ $b->jadwalLapangan?->jam_mulai ?? '--:--' }} - {{ $b->jadwalLapangan?->jam_selesai ?? '--:--' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-600',
                                    'booked' => 'bg-emerald-100 text-emerald-600',
                                    'selesai' => 'bg-slate-100 text-slate-600',
                                    'dibatalkan' => 'bg-rose-100 text-rose-600',
                                ];
                                $class = $statusClasses[$b->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $class }}">
                                {{ $b->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="/user/booking" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs uppercase tracking-tighter">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 font-medium italic text-sm">
                            Belum ada riwayat pemesanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection