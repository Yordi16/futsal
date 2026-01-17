@extends('layouts.user')

@section('page_title', 'Pilih Jadwal Main')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="space-y-8">

        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('user.lapangan') }}"
                    class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-600 hover:bg-indigo-950 hover:text-white transition-all shadow-sm">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tight">Pilih Jadwal</h3>
            </div>


            <div
                class="flex flex-row items-center gap-4 md:gap-6 p-4 md:p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl overflow-hidden shadow-md flex-shrink-0">
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
                    <img src="{{ $imageUrl }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-black text-slate-800 leading-tight">{{ $lapangan->nama_lapangan }}
                    </h4>
                    <p class="text-slate-500 text-xs font-medium uppercase tracking-widest mt-1">{{ $lapangan->jenis }}</p>
                    <p class="text-indigo-600 font-black text-base mt-1">
                        Rp {{ number_format($lapangan->harga_per_jam, 0, ',', '.') }} <span
                            class="text-[10px] text-slate-400">/ jam</span>
                    </p>
                </div>
            </div>
        </div>


        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <h4 class="text-base md:text-lg font-black text-slate-800 uppercase tracking-tight">Pilih Slot Jadwal Tersedia
            </h4>
            <div class="flex gap-4 text-[10px] font-black uppercase tracking-widest">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-emerald-500 rounded"></div> Tersedia
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-slate-300 rounded"></div> Terisi
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @php $currentDate = null; @endphp

            @forelse($jadwals as $jadwal)
                @if ($currentDate !== $jadwal->tanggal)
                            @if ($currentDate !== null)
                                    </div>
                                </div>
                            @endif

                    @php
                        $currentDate = $jadwal->tanggal;
                        $dateId = 'date-' . \Carbon\Carbon::parse($jadwal->tanggal)->format('Ymd');
                    @endphp

                    <button onclick="toggleDate('{{ $dateId }}')"
                        class="w-full flex items-center justify-between bg-indigo-950 text-white px-5 py-4 rounded-[1.2rem] md:rounded-[1.5rem] shadow-lg hover:bg-indigo-900 transition-all">
                        <span class="text-[11px] md:text-sm font-black tracking-widest uppercase flex items-center">
                            <i class="fas fa-calendar-alt mr-3 opacity-70"></i>
                            {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}
                        </span>
                        <i id="icon-{{ $dateId }}" class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                    </button>

                    <div id="{{ $dateId }}" class="hidden pt-3 transition-all duration-500">
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
                @endif

                <div
                    class="p-3 md:p-6 rounded-2xl md:rounded-3xl border-2 transition-all 
                                {{ $jadwal->status_slot === 'tersedia' ? 'border-emerald-100 bg-white shadow-sm' : 'border-slate-100 bg-slate-50 opacity-60' }}">

                    <div class="flex justify-between items-start mb-2 md:mb-4">
                        <div
                            class="w-7 h-7 md:w-10 md:h-10 rounded-lg md:rounded-xl flex items-center justify-center {{ $jadwal->status_slot === 'tersedia' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-200 text-slate-400' }}">
                            <i class="fas fa-clock text-[10px] md:text-base"></i>
                        </div>
                        <span
                            class="text-[8px] md:text-[10px] font-black uppercase px-2 py-0.5 rounded-md {{ $jadwal->status_slot === 'tersedia' ? 'bg-emerald-500 text-white' : 'bg-slate-300 text-slate-600' }}">
                            {{ $jadwal->status_slot }}
                        </span>
                    </div>

                    <h5 class="text-sm md:text-xl font-black text-slate-800">{{ $jadwal->jam_mulai }} -
                        {{ $jadwal->jam_selesai }}
                    </h5>

                    <div class="mt-1 mb-3 md:mb-6">
                        <p class="text-slate-500 text-[9px] md:text-xs font-medium">Durasi: {{ $jadwal->durasi }} Jam</p>
                        <p class="text-emerald-600 font-black text-[10px] md:text-sm mt-0.5">
                            Total: Rp {{ number_format($jadwal->total_harga, 0, ',', '.') }}
                        </p>
                    </div>

                    @if ($jadwal->status_slot === 'tersedia')
                        <form id="form-booking-{{ $jadwal->id }}" action="/user/booking" method="POST">
                            @csrf
                            <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                            <button type="button"
                                onclick="confirmBooking('{{ $jadwal->id }}', '{{ $jadwal->jam_mulai }}', '{{ $jadwal->jam_selesai }}')"
                                class="w-full py-2 md:py-3 bg-indigo-950 text-white rounded-lg md:rounded-xl font-bold text-[9px] md:text-sm hover:bg-emerald-500 transition-all uppercase tracking-widest shadow-md">
                                Booking
                            </button>
                        </form>
                    @else
                        <button disabled
                            class="w-full py-2 md:py-3 bg-slate-200 text-slate-400 rounded-lg md:rounded-xl font-bold text-[9px] md:text-sm uppercase tracking-widest cursor-not-allowed">
                            Terisi
                        </button>
                    @endif
                </div>

                @if ($loop->last)
                        </div>
                    </div>
                @endif
            @empty
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-300">
            <i class="fas fa-calendar-times text-4xl text-slate-300 mb-4"></i>
            <h4 class="text-lg font-bold text-slate-800">Tidak ada jadwal tersedia</h4>
        </div>
    @endforelse
    </div>
    </div>

    <script>
        function toggleDate(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            el.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        function confirmBooking(id, mulai, selesai) {
            Swal.fire({
                title: 'Konfirmasi Booking',
                text: "Jam " + mulai + " - " + selesai + ". Lanjutkan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#1e1b4b',
                confirmButtonText: 'Ya, Booking!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-booking-' + id).submit();
                }
            })
        }
    </script>
@endsection