@extends('layouts.user')

@section('page_title', 'Dashboard User')

@section('content')
    <div class="space-y-6 md:space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">
                    Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
                </h3>
                <p class="text-slate-500 text-sm font-medium mt-1">Berikut adalah ringkasan aktivitas booking Anda.</p>
            </div>
            <a href="/user/lapangan"
                class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3.5 rounded-2xl font-black text-[10px] md:text-xs transition-all shadow-lg shadow-emerald-500/20 uppercase tracking-[0.15em] text-center active:scale-95">
                Main Sekarang
            </a>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            <div
                class="bg-indigo-50/50 p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border border-indigo-100 relative overflow-hidden group">
                <i
                    class="fas fa-calendar-check absolute -right-3 -bottom-3 text-5xl text-indigo-200/50 group-hover:scale-110 transition-transform opacity-50"></i>
                <p class="text-[8px] md:text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-1">Mendatang</p>
                <h4 class="text-2xl md:text-4xl font-black text-indigo-900 leading-none">{{ $upcomingCount }}</h4>
                <p class="text-[9px] md:text-xs text-indigo-600/70 font-bold mt-2 uppercase tracking-tight">Jadwal</p>
            </div>

            <div
                class="bg-emerald-50/50 p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border border-emerald-100 relative overflow-hidden group">
                <i
                    class="fas fa-history absolute -right-3 -bottom-3 text-5xl text-emerald-200/50 group-hover:scale-110 transition-transform opacity-50"></i>
                <p class="text-[8px] md:text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Total Main
                </p>
                <h4 class="text-2xl md:text-4xl font-black text-emerald-900 leading-none">{{ $totalMainCount }}</h4>
                <p class="text-[9px] md:text-xs text-emerald-600/70 font-bold mt-2 uppercase tracking-tight">Selesai</p>
            </div>

            <div
                class="bg-amber-50/50 p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border border-amber-100 relative overflow-hidden group col-span-2 md:col-span-1">
                <i
                    class="fas fa-medal absolute -right-3 -bottom-3 text-5xl text-amber-200/50 group-hover:scale-110 transition-transform opacity-50"></i>
                <p class="text-[8px] md:text-[10px] font-black uppercase tracking-widest text-amber-400 mb-1">Status</p>
                <h4 class="text-2xl md:text-4xl font-black text-amber-900 leading-none">Reguler</h4>
                <p class="text-[9px] md:text-xs text-amber-600/70 font-bold mt-2 uppercase tracking-tight">Aktif</p>
            </div>
        </div>


        <div class="pt-4">
            <div class="flex items-center justify-between mb-5 px-1">
                <h3
                    class="text-sm md:text-base font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-5 bg-emerald-500 rounded-full"></span>
                    Booking Terbaru
                </h3>
                <a href="/user/booking"
                    class="text-[11px] font-bold text-indigo-600 hover:underline uppercase tracking-tighter">Lihat Semua</a>
            </div>


            <div class="hidden md:block overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4">Lapangan</th>
                            <th class="px-6 py-4">Waktu & Tanggal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentBookings as $b)
                            <tr class="hover:bg-slate-50/30 transition-all">
                                <td class="px-6 py-4 font-extrabold text-slate-700 text-sm">
                                    {{ $b->jadwalLapangan?->lapangan?->nama_lapangan ?? 'Lapangan' }}
                                    <div class="text-[9px] text-indigo-400 font-bold uppercase mt-0.5 italic">
                                        {{ $b->jadwalLapangan?->lapangan?->jenis_lapangan }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-600">
                                            {{ $b->jadwalLapangan ? \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                        <span class="text-[11px] text-emerald-500 font-black tracking-wider uppercase">
                                            {{ substr($b->jadwalLapangan->jam_mulai, 0, 5) }} -
                                            {{ substr($b->jadwalLapangan->jam_selesai, 0, 5) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php

                                        $statusStyles = [
                                            'pending' => 'bg-amber-100 text-amber-600',
                                            'booked' => 'bg-emerald-100 text-emerald-600',
                                            'selesai' => 'bg-slate-800 text-white',
                                            'dibatalkan' => 'bg-rose-100 text-rose-600',
                                        ];
                                        $currentStyle = $statusStyles[$b->status] ?? 'bg-slate-100 text-slate-600';
                                    @endphp

                                    <span
                                        class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase inline-block tracking-wider {{ $currentStyle }}">
                                        {{ $b->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-end gap-1.5">

                                        <a href="/user/booking"
                                            class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:bg-indigo-950 hover:text-white transition-all active:scale-90 group border border-slate-100 relative">


                                            <span class="grid place-items-center w-full h-full">
                                                <i
                                                    class="fas fa-arrow-right text-[12px] leading-[0] group-hover:text-emerald-400 transition-colors transform translate-x-[0.5px]"></i>
                                            </span>

                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Belum ada booking.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="md:hidden space-y-4">
                @forelse($recentBookings as $b)
                    <div class="bg-white p-5 rounded-[1.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-amber-500 text-white',
                                    'booked' => 'bg-emerald-500 text-white',
                                    'selesai' => 'bg-slate-800 text-white',
                                    'dibatalkan' => 'bg-rose-500 text-white',
                                ];
                                $currentStyle = $statusStyles[$b->status] ?? 'bg-slate-100 text-slate-500';
                            @endphp
                            <span
                                class="px-4 py-1.5 rounded-bl-2xl text-[8px] font-black uppercase tracking-widest {{ $currentStyle }}">
                                {{ $b->status }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-3">
                            <div>
                                <h4 class="text-sm font-black text-slate-800 tracking-tight leading-none uppercase pr-16">
                                    {{ $b->jadwalLapangan?->lapangan?->nama_lapangan }}
                                </h4>
                                <span class="text-[9px] font-bold text-indigo-500/70 tracking-widest uppercase block mt-1">
                                    {{ $b->jadwalLapangan?->lapangan?->jenis_lapangan }}
                                </span>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400">
                                        <i class="far fa-calendar-alt text-[10px]"></i>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-600">
                                        {{ $b->jadwalLapangan ? \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->translatedFormat('d M y') : '-' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500">
                                        <i class="far fa-clock text-[10px]"></i>
                                    </div>
                                    <span class="text-[10px] font-black text-emerald-600">
                                        {{ substr($b->jadwalLapangan->jam_mulai, 0, 5) }}-{{ substr($b->jadwalLapangan->jam_selesai, 0, 5) }}
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="absolute bottom-4 right-4 flex flex-col items-center gap-1">

                            <a href="/user/booking"
                                class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:bg-indigo-950 hover:text-white transition-all active:scale-90">
                                <i class="fas fa-arrow-right text-[10px] leading-none ml-0.5"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <p class="text-xs font-bold text-slate-400 italic">Belum ada booking terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection