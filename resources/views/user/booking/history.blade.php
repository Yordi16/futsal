@extends('user.layout')

@section('content')
{{-- Gunakan w-full agar mengambil lebar penuh layar --}}
<div class="w-full px-4 sm:px-6 lg:px-8 mt-10">
    
    <div class="max-w-7xl mx-auto"> {{-- Pembatas lebar maksimal agar tidak terlalu melar di monitor besar --}}
        
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-2xl font-extrabold text-gray-800">Riwayat Booking Saya</h2>
            <div class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-100 rounded-lg">
                <span class="text-sm font-medium text-blue-700">Total Transaksi: </span>
                <span class="ml-2 text-sm font-bold text-blue-800">{{ $bookings->count() }}</span>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
            {{-- Hapus overflow-x-auto JIKA Anda ingin tabel dipaksa masuk tanpa scroll --}}
            {{-- Tambahkan min-w-full agar tabel memenuhi kontainer --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Lapangan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Jam</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($bookings as $b)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-900">{{ $b->lapangan->nama_lapangan }}</div>
                                    <div class="text-xs text-gray-400">{{ $b->lapangan->jenis }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 flex items-center">
                                        {{ $b->tanggal }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-block px-3 py-1 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-full">
                                        {{ $b->jam_mulai }} - {{ $b->jam_selesai }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-gray-900">
                                    Rp {{ number_format($b->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection