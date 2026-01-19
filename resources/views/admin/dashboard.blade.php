@extends('layouts.admin')

@section('content')
    <div class="space-y-10">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center">
                    <i class="fas fa-grid-2 text-emerald-500"></i> Dashboard Overview
                </h1>
                <p class="text-slate-500 font-medium mt-1">Pantau performa bisnis futsal Anda hari ini.</p>
            </div>
            <div class="text-sm font-bold px-4 py-2 bg-slate-100 rounded-xl text-slate-600">
                <i class="fas fa-calendar-day mr-2 text-indigo-500"></i> {{ date('d M Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div
                class="group bg-white p-1 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                <div class="bg-indigo-50 p-8 rounded-[2.3rem] flex items-center justify-between overflow-hidden relative">
                    <i
                        class="fas fa-layer-group absolute -right-4 -bottom-4 text-7xl text-indigo-100 group-hover:scale-110 transition-transform"></i>
                    <div class="relative z-10">
                        <p class="text-xs font-black uppercase tracking-widest text-indigo-400">Total Lapangan</p>
                        <h2 class="text-4xl font-black text-indigo-900 mt-1">{{ $totalLapangan }}</h2>
                    </div>
                    <div
                        class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200 relative z-10">
                        <i class="fas fa-futbol fa-xl"></i>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.booking.index') }}" class="block">
                <div class="group bg-white p-1 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                    
                    <div class="bg-amber-50 p-8 rounded-[2.3rem] flex items-center justify-between overflow-hidden relative">
                        <i
                        class="fas fa-ticket-alt absolute -right-4 -bottom-4 text-7xl text-amber-100 group-hover:scale-110 transition-transform"></i>
                        <div class="relative z-10">
                            <p class="text-xs font-black uppercase tracking-widest text-amber-500">Total Booking</p>
                            <h2 class="text-4xl font-black text-amber-900 mt-1">{{ $totalBooking }}</h2>
                        </div>
                        <div
                        class="w-14 h-14 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-200 relative z-10">
                        <i class="fas fa-receipt fa-xl"></i>
                    </div>
                </div>
            </div>
            </a>

        <a href="{{ route('admin.report.index') }}" class="block">
            <div
                class="group bg-white p-1 rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                <div class="bg-emerald-50 p-8 rounded-[2.3rem] flex items-center justify-between overflow-hidden relative">
                    <i
                        class="fas fa-wallet absolute -right-4 -bottom-4 text-7xl text-emerald-100 group-hover:scale-110 transition-transform"></i>
                    <div class="relative z-10">
                        <p class="text-xs font-black uppercase tracking-widest text-emerald-500">Total Pendapatan</p>
                        <h2 class="text-2xl font-black text-emerald-900 mt-1">Rp
                            {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h2>
                    </div>
                    <div
                        class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 relative z-10">
                        <i class="fas fa-money-bill-trend-up fa-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        </a>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                    <i class="fas fa-clock-rotate-left text-indigo-500"></i> Booking Terkini
                </h3>
                <a href="/admin/booking"
                    class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest bg-indigo-50 px-4 py-2 rounded-xl transition">Lihat
                    Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/50 text-slate-400">
                        <tr>
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">User</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Lapangan</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em]">Jadwal</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($bookingTerbaru as $b)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                                            {{ substr($b->user->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-slate-700 text-sm">{{ $b->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-sm font-semibold text-slate-600 italic">
                                        {{ $b->jadwalLapangan->lapangan->nama_lapangan ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-slate-500 font-medium">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-indigo-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->format('Y-m-d') }}</span>
                                        <span class="text-slate-200">|</span>
                                        <i class="far fa-clock text-indigo-400"></i>
                                        <span>
                                            {{ date('H:i', strtotime($b->jadwalLapangan->jam_mulai)) }} -
                                            {{ date('H:i', strtotime($b->jadwalLapangan->jam_selesai)) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @php
                                        $config = match ($b->status) {
                                            'pending' => [
                                                'bg' => 'bg-amber-100',
                                                'text' => 'text-amber-700',
                                                'icon' => 'fa-clock',
                                            ],
                                            'booked' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-700',
                                                'icon' => 'fa-check-circle',
                                            ],
                                            'selesai' => [
                                                'bg' => 'bg-emerald-100',
                                                'text' => 'text-emerald-700',
                                                'icon' => 'fa-flag-checkered',
                                            ],
                                            'batal', 'dibatalkan' => [
                                                'bg' => 'bg-rose-100',
                                                'text' => 'text-rose-700',
                                                'icon' => 'fa-times-circle',
                                            ],
                                            default => [
                                                'bg' => 'bg-slate-100',
                                                'text' => 'text-slate-700',
                                                'icon' => 'fa-question-circle',
                                            ],
                                        };
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $config['bg'] }} {{ $config['text'] }}">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                        {{ $b->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center">
                                    <div class="flex flex-col items-center opacity-20">
                                        <i class="fas fa-folder-open text-6xl mb-4"></i>
                                        <p class="font-black uppercase tracking-widest text-sm text-slate-400">Belum ada
                                            booking
                                            terkini</p>
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