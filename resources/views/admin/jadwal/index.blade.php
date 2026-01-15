@extends('layouts.admin')

@section('content')
    <div class="space-y-8 no-scrollbar" x-data="{
            openLapangans: [],
            openTanggals: [],
            showSuccess: true,
            toggleLapangan(id) {
                if (this.openLapangans.includes(id)) {

                    this.openLapangans = this.openLapangans.filter(i => i !== id);


                    this.openTanggals = this.openTanggals.filter(tglKey => !tglKey.startsWith(id));
                } else {
                    this.openLapangans.push(id);
                }
            },
            toggleTanggal(id) {
                if (this.openTanggals.includes(id)) {
                    this.openTanggals = this.openTanggals.filter(i => i !== id);
                } else {
                    this.openTanggals.push(id);
                }
            }
        }">


        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <i class="fas fa-calendar-alt text-indigo-500"></i> Manajemen Jadwal
                </h1>
                <p class="text-slate-500 font-medium mt-1">Atur ketersediaan jadwal untuk setiap lapangan.</p>
            </div>

            <a href="{{ route('admin.jadwal.create') }}"
                class="flex items-center justify-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform active:scale-95">
                <i class="fas fa-plus"></i>
                Tambah Jadwal Baru
            </a>
        </div>


        @if (session('success'))
            <div x-show="showSuccess"
                class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white text-xs">
                        <i class="fas fa-check"></i>
                    </div>
                    <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
                </div>
                <button @click="showSuccess = false" class="text-emerald-400 hover:text-emerald-600 p-2">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        @endif


        @forelse($jadwals->sortBy('lapangan_id')->groupBy('lapangan.nama_lapangan') as $namaLapangan => $jadwalPerLapangan)
            @php $lapanganId = (string) $jadwalPerLapangan->first()->lapangan_id; @endphp

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">

                <div @click="toggleLapangan('{{ $lapanganId }}')"
                    class="px-8 py-6 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-slate-50 transition-all">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100">
                            #{{ $lapanganId }}
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800">{{ $namaLapangan }}</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">
                                {{ $jadwalPerLapangan->count() }} Total Slot
                            </p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down text-slate-300 transition-transform duration-300"
                        :class="openLapangans.includes('{{ $lapanganId }}') ? 'rotate-180 text-indigo-500' : ''"></i>
                </div>


                <div x-show="openLapangans.includes('{{ $lapanganId }}')" x-collapse x-cloak class="border-t border-slate-100">
                    @foreach ($jadwalPerLapangan->sortBy('tanggal')->groupBy('tanggal') as $tanggal => $items)
                        @php $tanggalKey = $lapanganId . $tanggal; @endphp

                        <div class="border-b border-slate-50 last:border-0">
                            <div @click="toggleTanggal('{{ $tanggalKey }}')"
                                class="px-10 py-4 bg-white flex items-center justify-between cursor-pointer hover:bg-indigo-50/30 transition-all">
                                <div class="flex items-center gap-3">
                                    <i class="far fa-calendar text-indigo-400"></i>
                                    <span
                                        class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</span>
                                    <span
                                        class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-md text-slate-500 font-black uppercase">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l') }}</span>
                                </div>
                                <span
                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">{{ $items->count() }}
                                    Sesi</span>
                            </div>


                            <div x-show="openTanggals.includes('{{ $tanggalKey }}')" x-collapse x-cloak
                                class="bg-slate-50/30 px-8 pb-6">
                                <div class="overflow-x-auto rounded-2xl border border-slate-100 bg-white">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="text-slate-400 border-b border-slate-50">
                                                <th class="px-6 py-4 text-left text-[9px] font-black uppercase tracking-widest">
                                                    Sesi Waktu</th>
                                                <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">
                                                    Status</th>
                                                <th class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50">
                                            @foreach ($items->sortBy('jam_mulai') as $j)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4 text-sm">
                                                        <span
                                                            class="px-3 py-1.5 bg-slate-100 rounded-lg text-slate-600 font-bold tracking-tight">
                                                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                                            {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center text-sm">
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase rounded-full {{ $j->status_slot == 'tersedia' ? 'bg-emerald-100 text-emerald-700' : ($j->status_slot == 'booked' ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700') }}">
                                                            <i
                                                                class="fas {{ $j->status_slot == 'tersedia' ? 'fa-check' : ($j->status_slot == 'booked' ? 'fa-lock' : 'fa-ban') }}"></i>
                                                            {{ $j->status_slot }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center justify-center gap-2">
                                                            <a href="{{ route('admin.jadwal.edit', $j->id) }}"
                                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all">
                                                                <i class="fas fa-edit text-[10px]"></i>
                                                            </a>
                                                            <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST"
                                                                onsubmit="return confirm('Hapus jadwal ini?')">
                                                                @csrf @method('DELETE')
                                                                <button
                                                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all">
                                                                    <i class="fas fa-trash text-[10px]"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-[2rem] border border-dashed border-slate-300 text-slate-400">
                <i class="fas fa-calendar-times text-5xl mb-4"></i>
                <p class="font-bold">Belum ada jadwal yang dibuat.</p>
            </div>
        @endforelse
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection