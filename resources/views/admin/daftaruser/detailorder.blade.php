@extends('layouts.admin')

@section('content')
<div class="space-y-8">

   <div class="flex items-center justify-between">
    <h1 class="text-3xl font-black text-slate-800">
        Riwayat Booking
    </h1>

    <p class="text-2xl text-slate-500">
        {{ $user->name }}
    </p>
</div>

    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b">
                <tr class="text-slate-400">
                    <th class="px-6 py-4 text-left text-[9px] font-black uppercase">Lapangan</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase">Jam</th>
                    <th class="px-6 py-4 text-right text-[9px] font-black uppercase">Total</th>
                    <th class="px-6 py-4 text-center text-[9px] font-black uppercase">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 font-bold">
                            {{ $booking->jadwalLapangan->lapangan->nama_lapangan }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $booking->jadwalLapangan->tanggal }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $booking->jadwalLapangan->jam_mulai }} -
                            {{ $booking->jadwalLapangan->jam_selesai }}
                        </td>
                        <td class="px-6 py-4 text-right font-black text-emerald-600">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $booking->status }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 text-slate-400 font-bold">
                            User belum pernah booking
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
