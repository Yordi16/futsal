@extends('layouts.user')

@section('page_title', 'Pilih Jadwal Main')

@section('content')
<div class="space-y-8">
    {{-- Info Lapangan Singkat --}}
    <div class="flex items-center gap-6 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
        <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-md">
            @if($lapangan->foto)
                <img src="{{ asset('storage/' . $lapangan->foto) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                    <i class="fas fa-image text-2xl"></i>
                </div>
            @endif
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800">{{ $lapangan->nama_lapangan }}</h3>
            <p class="text-emerald-600 font-bold text-lg">Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} <span class="text-xs text-slate-400">/ jam</span></p>
        </div>
    </div>

    {{-- Instruksi --}}
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-black text-slate-800 uppercase tracking-tight">Pilih Slot Waktu Tersedia</h4>
        <div class="flex gap-4 text-[10px] font-black uppercase tracking-widest">
            <div class="flex items-center gap-2"><div class="w-3 h-3 bg-emerald-500 rounded"></div> Tersedia</div>
            <div class="flex items-center gap-2"><div class="w-3 h-3 bg-slate-300 rounded"></div> Terisi</div>
        </div>
    </div>

    {{-- Jadwal Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php $currentDate = null; @endphp
        
        @forelse($jadwals as $jadwal)
            {{-- Label Tanggal jika berganti hari --}}
            @if($currentDate !== $jadwal->tanggal)
                @php $currentDate = $jadwal->tanggal; @endphp
                <div class="col-span-full mt-4">
                    <span class="bg-indigo-950 text-white px-5 py-2 rounded-full text-xs font-black shadow-lg">
                        <i class="fas fa-calendar-day mr-2"></i> {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                    </span>
                </div>
            @endif

            <div class="relative group">
                {{-- Cek menggunakan status_slot --}}
                <div class="p-6 rounded-3xl border-2 transition-all duration-300 
                    {{ $jadwal->status_slot === 'tersedia' 
                        ? 'border-emerald-100 bg-white hover:border-emerald-500 hover:shadow-xl hover:shadow-emerald-500/10' 
                        : 'border-slate-100 bg-slate-50 opacity-60' }}">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $jadwal->status_slot === 'tersedia' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-200 text-slate-400' }}">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase px-3 py-1 rounded-lg {{ $jadwal->status_slot === 'tersedia' ? 'bg-emerald-500 text-white' : 'bg-slate-300 text-slate-600' }}">
                            {{ $jadwal->status_slot }}
                        </span>
                    </div>

                    <h5 class="text-xl font-black text-slate-800">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</h5>
                    <p class="text-slate-500 text-xs font-medium mb-6">Durasi: 1 Jam Pertandingan</p>

                    {{-- Logic Tombol --}}
                    @if($jadwal->status_slot === 'tersedia')
                        <form action="/user/booking" method="POST">
                            @csrf
                            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                            <button type="submit" class="w-full py-3 bg-indigo-950 text-white rounded-xl font-bold text-sm hover:bg-emerald-500 transition-all uppercase tracking-widest shadow-lg shadow-indigo-950/20">
                                Booking Slot
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full py-3 bg-slate-200 text-slate-400 rounded-xl font-bold text-sm uppercase tracking-widest cursor-not-allowed">
                            Sudah Terisi
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-300">
                <i class="fas fa-calendar-times text-4xl text-slate-300 mb-4"></i>
                <h4 class="text-lg font-bold text-slate-800">Tidak ada jadwal untuk saat ini</h4>
                <p class="text-slate-500">Admin belum merilis jadwal untuk lapangan ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection