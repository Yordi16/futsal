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
                    <i class="fas fa-file-invoice text-indigo-500"></i> Manajemen Booking
                </h1>
                <p class="text-slate-500 font-medium mt-1.5">Kelola konfirmasi booking lapangan.</p>
            </div>

            <div class="flex gap-4">
                <div class="bg-indigo-50 px-6 py-3 rounded-2xl border border-indigo-100 flex flex-col">
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400">Total Booking</span>
                    <span class="text-xl font-black text-indigo-700">{{ $bookings->count() }}</span>
                </div>
            </div>
        </div>


        @if (session('success'))
            <div x-show="showSuccess"
                class="p-4 bg-emerald-500 text-white rounded-[1.5rem] flex items-center justify-between shadow-lg shadow-emerald-100 animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
                <button @click="showSuccess = false" class="opacity-70 hover:opacity-100 transition-opacity">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif


        @forelse($bookings->sortBy('jadwalLapangan.lapangan_id')->groupBy('jadwalLapangan.lapangan.nama_lapangan') as $namaLapangan => $bookingPerLapangan)
            @php $lapanganId = (string) $bookingPerLapangan->first()->jadwalLapangan->lapangan_id; @endphp

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-6 transition-all">

                <div @click="toggleLapangan('{{ $lapanganId }}')"
                    class="px-8 py-6 bg-slate-50/50 flex items-center justify-between cursor-pointer hover:bg-slate-100/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-100">
                            <i class="fas fa-skating text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $namaLapangan }}</h3>
                            <p class="text-[10px] text-indigo-500 font-black uppercase tracking-[0.2em]">
                                {{ $bookingPerLapangan->count() }} TOTAL BOOKING</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <i class="fas fa-chevron-down text-slate-300 transition-transform duration-300"
                            :class="openLapangans.includes('{{ $lapanganId }}') ? 'rotate-180 text-indigo-500' : ''"></i>
                    </div>
                </div>

                <div x-show="openLapangans.includes('{{ $lapanganId }}')" x-collapse x-cloak
                    class="border-t border-slate-100">

                    @foreach ($bookingPerLapangan->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->jadwalLapangan->tanggal)->format('Y-m-d');
            })->sortKeysDesc() as $tanggal => $items)
                        @php $tanggalKey = $lapanganId . $tanggal; @endphp

                        <div class="border-b border-slate-50 last:border-0">

                            <div @click="toggleTanggal('{{ $tanggalKey }}')"
                                class="px-10 py-4 bg-white flex items-center justify-between cursor-pointer hover:bg-indigo-50/30 transition-all">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500">
                                        <i class="far fa-calendar-check text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700 text-sm">
                                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                        </span>
                                        <span class="text-[9px] text-slate-400 font-black uppercase tracking-widest">
                                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span
                                        class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                                        {{ $items->count() }} BOOKING
                                    </span>
                                </div>
                            </div>


                            <div x-show="openTanggals.includes('{{ $tanggalKey }}')" x-collapse x-cloak
                                class="bg-slate-50/30 px-8 pb-6 pt-2">
                                <div class="overflow-hidden rounded-[1.5rem] border border-slate-100 bg-white shadow-sm">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="text-slate-400 bg-slate-50/50 border-b border-slate-100">
                                                <th
                                                    class="px-6 py-4 text-left text-[9px] font-black uppercase tracking-widest">
                                                    Pelanggan</th>
                                                <th
                                                    class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">
                                                    Sesi Waktu</th>
                                                <th
                                                    class="px-6 py-4 text-right text-[9px] font-black uppercase tracking-widest">
                                                    Total Bayar</th>
                                                <th
                                                    class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">
                                                    Status</th>
                                                <th
                                                    class="px-6 py-4 text-center text-[9px] font-black uppercase tracking-widest">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50">

                                            @foreach ($items->sortBy('jadwalLapangan.jam_mulai') as $booking)
                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            <div
                                                                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400 border border-slate-200">
                                                                {{ substr($booking->user->name ?? '?', 0, 1) }}
                                                            </div>
                                                            <div class="flex flex-col">
                                                                <span
                                                                    class="font-black text-slate-700 leading-none">{{ $booking->user->name ?? '-' }}</span>
                                                                <span
                                                                    class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-tighter italic">#BK-{{ $booking->id }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span
                                                            class="px-3 py-1.5 bg-slate-100 rounded-lg text-slate-600 font-bold text-xs tracking-tight border border-slate-200">
                                                            {{ $booking->jadwalLapangan->jam_mulai }} -
                                                            {{ $booking->jadwalLapangan->jam_selesai }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-right font-black text-emerald-600">
                                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
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
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $config['bg'] }} {{ $config['text'] }} border border-white shadow-sm">
                                                            <i class="fas {{ $config['icon'] }}"></i>
                                                            {{ $booking->status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if ($booking->status !== 'dibatalkan' && $booking->status !== 'selesai')
                                                            <form
                                                                action="{{ route('admin.booking.update', $booking->id) }}"
                                                                method="POST"
                                                                class="flex items-center justify-center gap-2">
                                                                @csrf @method('PUT')
                                                                <div class="relative group">
                                                                    <select name="status"
                                                                        class="appearance-none bg-slate-50 border border-slate-200 rounded-xl pl-3 pr-8 py-1.5 text-[10px] font-bold text-slate-600 focus:ring-4 focus:ring-indigo-100 focus:outline-none transition-all cursor-pointer w-full">
                                                                        <option value="pending"
                                                                            {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                                            Pending</option>
                                                                        <option value="booked"
                                                                            {{ $booking->status == 'booked' ? 'selected' : '' }}>
                                                                            Booked</option>
                                                                        <option value="selesai"
                                                                            {{ $booking->status == 'selesai' ? 'selected' : '' }}>
                                                                            Selesai</option>
                                                                        <option value="dibatalkan"
                                                                            {{ $booking->status == 'dibatalkan' ? 'selected' : '' }}>
                                                                            Batalkan</option>
                                                                    </select>
                                                                    {{-- Ikon Panah --}}
                                                                    <div
                                                                        class="absolute inset-y-0 right-2.5 flex items-center pointer-events-none text-slate-400 group-hover:text-indigo-500 transition-colors">
                                                                        <i class="fas fa-chevron-down text-[8px]"></i>
                                                                    </div>
                                                                </div>
                                                                <button
                                                                    class="w-8 h-8 flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-90"
                                                                    title="Update">
                                                                    <i class="fas fa-check text-[10px]"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="flex items-center justify-center">
                                                                <span
                                                                    class="text-[9px] font-black text-slate-300 italic tracking-widest">
                                                                    <i class="fas fa-lock mr-1"></i> LOCKED
                                                                </span>
                                                            </div>
                                                        @endif
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
            <div class="text-center py-24 bg-white rounded-[2rem] border-2 border-dashed border-slate-200">
                <div class="flex flex-col items-center opacity-40">
                    <i class="fas fa-clipboard-list text-6xl mb-4 text-slate-300"></i>
                    <p class="font-black uppercase tracking-[0.2em] text-sm text-slate-400">Belum ada pesanan masuk</p>
                </div>
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


        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
