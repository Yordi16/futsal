@extends('layouts.user')

@section('page_title', 'Riwayat Booking Saya')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="space-y-6">


        <div class="flex flex-col md:flex-row md:items-center justify-between px-2 md:px-0 mb-8 gap-5">
            <div class="min-w-0">
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 leading-tight">
                    Riwayat Booking Anda
                </h1>
                <p class="text-slate-500 text-[11px] md:text-sm font-medium mt-1">
                    Pantau status dan riwayat booking anda.
                </p>
            </div>


            <a href="{{ route('user.lapangan') }}"
                class="flex items-center justify-center gap-2 px-4 py-2.5 md:px-6 md:py-3 bg-indigo-600 text-white rounded-xl md:rounded-2xl font-black text-[10px] md:text-xs uppercase tracking-[0.15em] shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all w-full md:w-auto">
                <i class="fas fa-plus-circle text-sm md:text-lg"></i>
                <span>Pesan Lagi</span>
            </a>
        </div>

        @if (session('success'))
            <div
                class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 md:px-6 md:py-4 rounded-xl md:rounded-2xl font-bold flex items-center gap-2 md:gap-3 mx-2 md:mx-0 shadow-sm">
                <i class="fas fa-check-circle text-base md:text-xl"></i>
                <span class="text-[11px] md:text-sm leading-tight">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4 px-2 md:px-0">
            @forelse($bookings as $b)
                <div
                    class="bg-white border border-slate-100 rounded-[1.5rem] md:rounded-[2rem] shadow-sm hover:shadow-md transition-all overflow-hidden">
                    <div class="p-4 md:p-8">
                        <div class="flex flex-col md:flex-row justify-between gap-4 md:items-center">


                            <div class="flex items-center gap-3 md:gap-4">
                                <div
                                    class="w-12 h-12 md:w-20 md:h-20 bg-indigo-50 rounded-xl md:rounded-2xl flex flex-col items-center justify-center text-indigo-600 border border-indigo-100 flex-shrink-0">
                                    <span
                                        class="text-[7px] md:text-[10px] font-black uppercase tracking-tighter opacity-60">ID</span>
                                    <span class="text-xs md:text-xl font-black">#{{ $b->id }}</span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm md:text-xl font-black text-slate-800 leading-tight truncate">
                                        {{ $b->jadwalLapangan?->lapangan?->nama_lapangan ?? 'Lapangan' }}
                                    </h4>
                                    <div class="flex flex-col gap-0.5 md:gap-2 mt-1 md:mt-2">
                                        <p class="text-slate-500 font-bold text-[9px] md:text-sm flex items-center gap-2">
                                            <i class="fas fa-calendar-alt text-indigo-500 w-3 md:w-4"></i>
                                            {{ $b->jadwalLapangan ? \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->translatedFormat('d M Y') : 'N/A' }}
                                        </p>
                                        <p class="text-emerald-600 font-black text-[9px] md:text-sm flex items-center gap-2">
                                            <i class="fas fa-clock w-3 md:w-4"></i>
                                            {{ $b->jadwalLapangan?->jam_mulai ? substr($b->jadwalLapangan->jam_mulai, 0, 5) : '--' }}
                                            -
                                            {{ $b->jadwalLapangan?->jam_selesai ? substr($b->jadwalLapangan->jam_selesai, 0, 5) : '--' }}
                                        </p>
                                    </div>
                                </div>
                            </div>


                            <div
                                class="flex flex-row md:flex-col justify-between items-center md:items-end bg-slate-50 md:bg-transparent p-3 md:p-0 rounded-xl md:rounded-none border border-slate-100 md:border-none">
                                <div class="text-left md:text-right">
                                    <p class="text-[7px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                        Total Bayar</p>
                                    <p class="text-sm md:text-2xl font-black text-indigo-600">
                                        Rp {{ number_format($b->total_harga, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="md:mt-3">
                                    @php
                                        $statusMap = [
                                            'pending' => ['bg-amber-100', 'text-amber-600', 'Menunggu Konfirmasi'],
                                            'booked' => ['bg-emerald-500', 'text-white', 'Dikonfirmasi'],
                                            'selesai' => ['bg-slate-100', 'text-slate-500', 'Selesai'],
                                            'dibatalkan' => ['bg-rose-100', 'text-rose-600', 'Dibatalkan'],
                                        ];
                                        $st = $statusMap[$b->status] ?? ['bg-slate-100', 'text-slate-600', $b->status];
                                    @endphp
                                    <span
                                        class="{{ $st[0] }} {{ $st[1] }} px-2.5 py-1 md:px-3 md:py-1.5 rounded-lg md:rounded-xl text-[7px] md:text-[10px] font-black uppercase tracking-widest shadow-sm inline-block whitespace-nowrap">
                                        {{ $st[2] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($b->status === 'pending')
                        <div
                            class="bg-rose-50/30 border-t border-dashed border-rose-100 px-4 py-3 md:px-6 md:py-4 flex justify-end">
                            <form id="form-cancel-{{ $b->id }}" action="{{ route('user.booking.cancel', $b->id) }}" method="POST"
                                class="w-full md:w-auto">
                                @csrf
                                <button type="button" onclick="confirmCancel('{{ $b->id }}')"
                                    class="group flex items-center justify-center gap-2 w-full md:w-auto md:px-6 py-2.5 bg-white text-rose-600 border border-rose-200 rounded-lg md:rounded-xl font-black text-[9px] md:text-[10px] uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fas fa-times-circle group-hover:rotate-90 transition-transform"></i>
                                    Batalkan Booking
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[2rem] border border-dashed border-slate-200 mx-2">
                    <i class="fas fa-history text-4xl text-slate-200 mb-4"></i>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada riwayat booking</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmCancel(id) {
            Swal.fire({
                title: 'Batalkan Booking?',
                text: "Jadwal ini akan tersedia kembali untuk pemain lain.",
                icon: 'warning',
                width: window.innerWidth < 768 ? '90%' : '500px',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#1e1b4b',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                customClass: {
                    popup: 'rounded-[2rem]',
                    title: 'text-lg md:text-2xl font-black',
                    htmlContainer: 'text-xs md:text-base',
                    confirmButton: 'text-xs md:text-sm py-3 px-6 mx-1',
                    cancelButton: 'text-xs md:text-sm py-3 px-6 mx-1'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-cancel-' + id).submit();
                }
            })
        }
    </script>
@endsection