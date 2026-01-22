@extends('layouts.user')

@section('page_title', 'Pilih Lapangan Terbaik')

@section('content')
    <div class="space-y-6 md:space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Daftar Lapangan.</h3>
                <p class="text-slate-500 font-medium text-sm md:text-base">Temukan lapangan yang sesuai dengan gaya
                    permainan tim Anda.</p>
            </div>


            <div
                class="flex items-center justify-center gap-1 bg-slate-100 p-1 rounded-2xl w-full max-w-md mx-auto md:mx-0 md:w-auto overflow-hidden">

                <a href="{{ route('user.lapangan') }}"
                    class="flex-1 text-center whitespace-nowrap px-3 py-2 rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition-all 
                                                           {{ !request('jenis') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }}">
                    Semua
                </a>


                <a href="{{ route('user.lapangan', ['jenis' => 'rumput sintetis']) }}"
                    class="flex-1 text-center whitespace-nowrap px-3 py-2 rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition-all 
                                                           {{ request('jenis') == 'rumput sintetis' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }}">
                    Rumput Sintetis
                </a>


                <a href="{{ route('user.lapangan', ['jenis' => 'vinyl']) }}"
                    class="flex-1 text-center whitespace-nowrap px-3 py-2 rounded-xl font-bold text-[10px] md:text-xs uppercase tracking-widest transition-all 
                                                           {{ request('jenis') == 'vinyl' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-indigo-600' }}">
                    Vinyl
                </a>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @forelse($lapangans as $lapangan)
                <a href="{{ $lapangan->status === 'tersedia' ? '/user/jadwal/' . $lapangan->id : '#' }}"
                    class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 overflow-hidden flex flex-col {{ $lapangan->status !== 'tersedia' ? 'cursor-default' : '' }}">


                    <div class="relative h-52 md:h-56 overflow-hidden">
                        @php
                            $type = strtolower($lapangan->jenis);
                            $imageUrl = 'https://images.unsplash.com/photo-1529900948632-5a968600f64b?q=80&w=800';

                            if (str_contains($type, 'rumput sintetis')) {
                                $imageUrl =
                                    'https://centroflor.id/wp-content/uploads/2023/09/Lapangan-Futsal-Rumput-Sintetis-Halim.jpg';
                            } elseif (str_contains($type, 'vinyl')) {
                                $imageUrl =
                                    'https://centroflor.id/wp-content/uploads/2023/08/Karpet-Vinyl-Futsal-biru-2.jpg';
                            }
                        @endphp

                        <img src="{{ $imageUrl }}" alt="{{ $lapangan->nama_lapangan }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        <div class="absolute top-4 right-4">
                            <span
                                class="bg-indigo-950/80 backdrop-blur-md text-emerald-400 px-4 py-2 rounded-xl text-[10px] font-black shadow-sm uppercase tracking-widest border border-white/10">
                                {{ $lapangan->jenis }}
                            </span>
                        </div>
                    </div>


                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="w-2 h-2 rounded-full {{ $lapangan->status === 'tersedia' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                <span
                                    class="text-[9px] font-black {{ $lapangan->status === 'tersedia' ? 'text-emerald-600' : 'text-rose-600' }} uppercase tracking-[0.2em]">
                                    {{ $lapangan->status ?? 'Tersedia Sekarang' }}
                                </span>
                            </div>
                            <h4 class="text-xl font-black text-slate-800 tracking-tight leading-tight">
                                {{ $lapangan->nama_lapangan }}
                            </h4>
                            <p class="text-slate-500 text-sm mt-2 leading-relaxed">
                                <span class="font-bold text-slate-700 uppercase text-[11px]">Jenis Lapangan:
                                    {{ $lapangan->jenis }}.</span>
                            </p>
                            <p class="text-slate-500 text-xs md:text-sm mt-1 leading-relaxed">Nikmati pengalaman bermain
                                terbaik
                                di {{ $lapangan->nama_lapangan }} dengan standar kualitas tinggi.</p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Tarif Per Jam
                                </p>
                                <p class="text-xl font-black text-indigo-600">
                                    <span class="text-xs">Rp</span>
                                    {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }}
                                </p>
                            </div>

                            @if ($lapangan->status === 'tersedia')
                                <div
                                    class="w-12 h-12 bg-indigo-950 text-white rounded-xl flex items-center justify-center group-hover:bg-emerald-500 transition-all shadow-lg shadow-indigo-950/20 active:scale-90">
                                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            @else
                                <div class="flex flex-col items-end gap-1">
                                    <button disabled
                                        class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl flex items-center gap-2 cursor-not-allowed border border-slate-200">
                                        <i class="fas fa-lock text-[10px]"></i>
                                        <span class="text-[9px] font-black uppercase tracking-widest">Maintenance</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-200">
                    <i class="fas fa-search text-3xl text-slate-200 mb-4"></i>
                    <h4 class="text-xl font-black text-slate-800 tracking-tight">Belum ada lapangan tersedia</h4>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection