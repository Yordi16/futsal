@extends('layouts.admin')

@section('content')
    <div class="space-y-8">


        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <i class="fas fa-chart-line text-emerald-500"></i> Laporan AriFutsal.
                </h1>
                <p class="text-slate-500 font-medium mt-1">Data laporan booking lapangan.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <a href="{{ route('admin.report.pdf', ['start_date' => $start, 'end_date' => $end]) }}"
                    class="flex items-center gap-2 px-6 py-3 bg-rose-50 text-rose-600 rounded-2xl font-bold text-sm hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-rose-100 uppercase tracking-widest">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>

                <a href="{{ route('admin.report.excel', ['start_date' => $start, 'end_date' => $end]) }}"
                    class="flex items-center gap-2 px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl font-bold text-sm hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100 uppercase tracking-widest">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
            </div>
        </div>


        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <form action="{{ route('admin.report.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2 mb-1 block">Tanggal
                        Mulai</label>
                    <input type="date" name="start_date" value="{{ $start }}"
                        class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                </div>
                <div class="flex-1">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-2 mb-1 block">Tanggal
                        Selesai</label>
                    <input type="date" name="end_date" value="{{ $end }}"
                        class="w-full bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-emerald-500 font-bold text-slate-700">
                </div>
                <button type="submit"
                    class="px-8 py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition-all">
                    Filter Data
                </button>
                @if ($start || $end)
                    <a href="{{ route('admin.report.index') }}"
                        class="px-4 py-3 text-slate-400 hover:text-rose-500 font-bold transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-wallet text-8xl text-emerald-600"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-black text-slate-800">Rp {{ number_format($total->sum('total'), 0, ',', '.') }}
                </h3>
                <p class="text-xs text-emerald-500 font-bold mt-2 flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> Dari {{ $bookings->count() }} transaksi sukses
                </p>
            </div>
        </div>


        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between">
                <h2 class="text-lg font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                    Tren Pendapatan Harian
                </h2>
                <span
                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-50 px-3 py-1 rounded-lg uppercase">
                    {{ $start ? \Carbon\Carbon::parse($start)->format('d M') : 'Awal' }} -
                    {{ $end ? \Carbon\Carbon::parse($end)->format('d M') : 'Sekarang' }}
                </span>
            </div>
            <div class="p-10">
                <div class="relative h-80">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-10 py-8 border-b border-slate-50">
                <h2 class="text-lg font-black text-slate-800 tracking-tight">Rincian Transaksi Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 text-slate-400">
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest">Pelanggan</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest">Lapangan</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black uppercase tracking-widest">Tanggal &
                                Waktu
                            </th>
                            <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest">Total Harga
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <span class="font-bold text-slate-700">{{ $booking->user->name ?? '-' }}</span>
                                </td>
                                <td class="px-8 py-5 font-medium text-slate-600">
                                    {{ $booking->jadwalLapangan->lapangan->nama_lapangan ?? '-' }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-slate-600">{{ $booking->jadwalLapangan->tanggal ?? '-' }}</span>
                                        <span
                                            class="text-[10px] font-bold text-emerald-500 uppercase">{{ $booking->jadwalLapangan->jam_mulai }}
                                            - {{ $booking->jadwalLapangan->jam_selesai }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="font-black text-emerald-600">Rp
                                        {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center py-12 text-slate-400 font-bold uppercase tracking-widest text-xs">
                                    Belum ada transaksi sukses</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('incomeChart');
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($total->pluck('tanggal')),
                datasets: [{
                    label: ' Pendapatan (Rp)',
                    data: @json($total->pluck('total')),
                    borderColor: '#10b981',
                    borderWidth: 4,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            strokeDashArray: 5,
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString();
                            },
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection