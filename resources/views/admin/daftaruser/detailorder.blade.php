@extends('layouts.admin')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="flex items-end justify-between border-b border-slate-100 pb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('admin.daftaruser.index') }}"
                        class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500">Kembali ke daftar
                        user</span>
                </div>
                <h1 class="text-3xl font-black text-slate-800">
                    Riwayat Booking
                </h1>
            </div>

            <div class="text-right">
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1">Nama
                    Customer</span>
                <p class="text-2xl font-black text-indigo-950 italic">
                    {{ $user->name }}
                </p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm table-fixed"> {{-- table-fixed agar lebar kolom konsisten --}}
                <thead>
                    <tr class="bg-slate-50/50 text-slate-400 uppercase">
                        <th class="w-1/3 px-8 py-5 text-left text-[10px] font-black tracking-widest">Informasi Lapangan</th>
                        <th class="px-6 py-5 text-center text-[10px] font-black tracking-widest">Tanggal Main</th>
                        <th class="px-6 py-5 text-center text-[10px] font-black tracking-widest">Durasi Jadwal</th>
                        <th class="px-6 py-5 text-right text-[10px] font-black tracking-widest">Total Bayar</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black tracking-widest">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-indigo-50/30 transition-all group">
                            {{-- LAPANGAN --}}
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-1.5 h-10 bg-indigo-500 rounded-full group-hover:scale-y-110 transition-transform">
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-700 text-base leading-tight">
                                            {{ $booking->jadwalLapangan->lapangan->nama_lapangan }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-1">
                                            Booking ID #{{ $booking->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- TANGGAL --}}
                            <td class="px-6 py-6 text-center">
                                <div class="font-bold text-slate-700 text-sm">
                                    {{ \Carbon\Carbon::parse($booking->jadwalLapangan->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </td>

                            {{-- JAM (Tanpa Detik) --}}
                            <td class="px-6 py-6 text-center">
                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-black text-xs">
                                    <i class="far fa-clock text-[10px]"></i>
                                    {{-- substr(..., 0, 5) digunakan untuk mengambil HH:mm saja --}}
                                    {{ substr($booking->jadwalLapangan->jam_mulai, 0, 5) }} -
                                    {{ substr($booking->jadwalLapangan->jam_selesai, 0, 5) }}
                                </div>
                            </td>

                            {{-- TOTAL HARGA --}}
                            <td class="px-6 py-6 text-right">
                                <div class="text-base font-black text-slate-800">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusStyle = [
                                        'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                        'booked' => 'bg-emerald-500 text-white border-emerald-600 shadow-sm shadow-emerald-100',
                                        'selesai' => 'bg-slate-100 text-slate-500 border-slate-200',
                                        'dibatalkan' => 'bg-rose-100 text-rose-600 border-rose-200',
                                    ];
                                    $style = $statusStyle[$booking->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                @endphp
                                <span
                                    class="{{ $style }} border px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest inline-block min-w-[110px]">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-24">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                        <i class="fas fa-calendar-times text-2xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-xs">
                                        Belum ada data booking untuk user ini
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection