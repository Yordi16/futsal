@extends('layouts.user')

@section('page_title', 'Riwayat Booking Saya')

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl font-bold flex items-center gap-3">
            <i class="fas fa-check-circle text-xl"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($bookings as $b)
        <div class="bg-white border border-slate-100 rounded-[2rem] p-6 shadow-sm hover:shadow-md transition-all">
            <div class="flex flex-col md:flex-row justify-between gap-6">
                {{-- Info Utama --}}
                <div class="flex gap-6">
                    <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex flex-col items-center justify-center text-indigo-600 border border-indigo-100">
                        <span class="text-[10px] font-black uppercase tracking-tighter">ID</span>
                        <span class="text-xl font-black">#{{ $b->id }}</span>
                    </div>
                    <div>
                        {{-- Null-safe untuk Nama Lapangan --}}
                        <h4 class="text-xl font-black text-slate-800">
                            {{ $b->jadwalLapangan?->lapangan?->nama_lapangan ?? 'Lapangan Tidak Ditemukan' }}
                        </h4>
                        
                        <p class="text-slate-500 font-medium flex items-center gap-2 mt-1">
                            <i class="fas fa-calendar text-xs"></i> 
                            {{-- Null-safe untuk Tanggal --}}
                            {{ $b->jadwalLapangan? \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->translatedFormat('d F Y') : 'Tanggal N/A' }}
                        </p>
                        
                        <p class="text-emerald-600 font-bold flex items-center gap-2">
                            <i class="fas fa-clock text-xs"></i> 
                            {{-- Null-safe untuk Jam --}}
                            {{ $b->jadwalLapangan?->jam_mulai ?? '--:--' }} - {{ $b->jadwalLapangan?->jam_selesai ?? '--:--' }}
                        </p>
                    </div>
                </div>

                {{-- Status & Harga --}}
                <div class="flex flex-row md:flex-col justify-between md:text-right border-t md:border-t-0 pt-4 md:pt-0">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar (COD)</p>
                        <p class="text-xl font-black text-slate-800">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-2">
                        @php
                            $statusMap = [
                                'pending' => ['bg-amber-100', 'text-amber-600', 'Menunggu Bayar'],
                                'booked' => ['bg-emerald-100', 'text-emerald-600', 'Dikonfirmasi'],
                                'selesai' => ['bg-slate-100', 'text-slate-600', 'Selesai'],
                            ];
                            $st = $statusMap[$b->status] ?? ['bg-slate-100', 'text-slate-600', $b->status];
                        @endphp
                        <span class="{{ $st[0] }} {{ $st[1] }} px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                            {{ $st[2] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="py-20 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <i class="fas fa-ticket-alt text-2xl text-slate-300"></i>
            </div>
            <h4 class="text-lg font-bold text-slate-800">Belum ada booking</h4>
            <p class="text-slate-500 mb-6">Anda belum memesan jadwal lapangan manapun.</p>
            <a href="/user/lapangan" class="bg-indigo-950 text-white px-8 py-3 rounded-xl font-bold uppercase text-xs tracking-widest">Pesan Sekarang</a>
        </div>
        @endforelse
    </div>
</div>
@endsection