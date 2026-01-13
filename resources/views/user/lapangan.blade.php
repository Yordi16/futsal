@extends('layouts.user')

@section('page_title', 'Pilih Lapangan Terbaik')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-2xl font-black text-slate-800">Daftar Lapangan Tersedia</h3>
            <p class="text-slate-500 font-medium">Temukan lapangan yang sesuai dengan gaya permainan tim Anda.</p>
        </div>
        <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl">
            <button class="px-4 py-2 bg-white text-indigo-600 shadow-sm rounded-xl font-bold text-xs">Semua</button>
            <button class="px-4 py-2 text-slate-500 hover:text-indigo-600 rounded-xl font-bold text-xs transition-all">Sintetis</button>
            <button class="px-4 py-2 text-slate-500 hover:text-indigo-600 rounded-xl font-bold text-xs transition-all">Matras</button>
        </div>
    </div>

    {{-- Grid Lapangan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($lapangans as $lapangan)
        <div class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 overflow-hidden flex flex-col">
            {{-- Image Header --}}
            <div class="relative h-56 overflow-hidden">
                @if($lapangan->foto)
                    <img src="{{ asset('storage/' . $lapangan->foto) }}" alt="{{ $lapangan->nama_lapangan }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="w-full h-full bg-slate-200 flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-slate-400"></i>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <span class="bg-white/90 backdrop-blur-sm text-indigo-600 px-4 py-2 rounded-xl text-xs font-black shadow-sm uppercase">
                        {{ $lapangan->tipe ?? 'Futsal' }}
                    </span>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 flex-1 flex flex-col">
                <div class="mb-4">
                    <h4 class="text-xl font-black text-slate-800 tracking-tight">{{ $lapangan->nama_lapangan }}</h4>
                    <p class="text-slate-500 text-sm line-clamp-2 mt-1">{{ $lapangan->deskripsi }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center gap-2 text-slate-600">
                        <i class="fas fa-arrows-alt text-emerald-500"></i>
                        <span class="text-xs font-bold uppercase tracking-tighter">Standar FIFA</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-600">
                        <i class="fas fa-lightbulb text-emerald-500"></i>
                        <span class="text-xs font-bold uppercase tracking-tighter">LED Lighting</span>
                    </div>
                </div>

                <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga mulai</p>
                        <p class="text-xl font-black text-emerald-600">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}<span class="text-[10px] text-slate-400">/Jam</span></p>
                    </div>
                    <a href="/user/jadwal/{{ $lapangan->id }}" class="w-12 h-12 bg-indigo-950 text-white rounded-xl flex items-center justify-center hover:bg-emerald-500 transition-all shadow-lg shadow-indigo-950/20">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-2xl text-slate-400"></i>
            </div>
            <h4 class="text-lg font-bold text-slate-800">Belum ada lapangan tersedia</h4>
            <p class="text-slate-500">Silakan kembali lagi nanti.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection