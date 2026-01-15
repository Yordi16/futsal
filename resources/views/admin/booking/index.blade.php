@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <i class="fas fa-file-invoice text-indigo-500"></i> Data Booking Pesanan
                </h1>
                <p class="text-slate-500 font-medium mt-1.5">Kelola dan konfirmasi booking pelanggan.</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-indigo-50 px-4 py-2 rounded-2xl border border-indigo-100">
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400 block">Total
                        Booking</span>
                    <span class="text-xl font-black text-indigo-700">{{ $bookings->count() }}</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div
                class="bg-emerald-500 text-white px-6 py-4 rounded-[1.5rem] shadow-lg shadow-emerald-100 flex items-center gap-3 animate-bounce">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif


        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden text-sm">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400">
                            <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-widest">No</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-widest">Pelanggan</th>
                            <th class="px-6 py-5 text-left text-[10px] font-black uppercase tracking-widest">Lapangan</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">Jadwal</th>
                            <th class="px-6 py-5 text-right text-[10px] font-black uppercase tracking-widest">Total Bayar
                            </th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">Status</th>
                            <th class="px-6 py-5 text-center text-[10px] font-black uppercase tracking-widest">Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-5 text-slate-400 font-medium">{{ $loop->iteration }}</td>

                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold border border-slate-200 uppercase">
                                            {{ substr($booking->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-700">{{ $booking->user->name ?? '-' }}</span>
                                            <span
                                                class="text-[10px] text-slate-400 uppercase font-bold tracking-tighter italic">ID
                                                #BK-{{ $booking->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 font-bold text-slate-600">
                                    {{ $booking->jadwalLapangan->lapangan->nama_lapangan ?? '-' }}
                                </td>

                                <td class="px-6 py-5 text-center">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($booking->jadwalLapangan->tanggal)->format('d/m/Y') }}</span>
                                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">
                                            {{ $booking->jadwalLapangan->jam_mulai }} -
                                            {{ $booking->jadwalLapangan->jam_selesai }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-right font-black text-emerald-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-5 text-center">
                                    @php

                                        $config = match ($booking->status) {
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
                                            'dibatalkan' => [
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
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $config['bg'] }} {{ $config['text'] }} border border-white/50 shadow-sm">
                                        <i class="fas {{ $config['icon'] }}"></i>
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST"
                                        class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PUT')

                                        <div class="relative group/select">
                                            <select name="status"
                                                class="appearance-none bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 pr-8 text-xs font-bold text-slate-600 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 focus:outline-none transition-all cursor-pointer">
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="booked" {{ $booking->status == 'booked' ? 'selected' : '' }}>Booked
                                                </option>
                                                <option value="selesai" {{ $booking->status == 'selesai' ? 'selected' : '' }}>
                                                    Selesai</option>
                                                <option value="dibatalkan" {{ $booking->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                                </option>
                                            </select>
                                            <i
                                                class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none group-hover/select:text-indigo-500 transition-colors"></i>
                                        </div>

                                        <button
                                            class="w-8 h-8 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-100 hover:-translate-y-0.5 transition-all"
                                            title="Update Status">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-20 text-center">
                                    <div class="flex flex-col items-center opacity-30">
                                        <i class="fas fa-clipboard-list text-6xl mb-4 text-slate-300"></i>
                                        <p class="font-black uppercase tracking-[0.2em] text-sm text-slate-400">Belum ada
                                            pesanan masuk</p>
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