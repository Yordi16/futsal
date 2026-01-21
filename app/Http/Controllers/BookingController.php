<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\JadwalLapangan;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::all();

        return view('user.booking', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_lapangans,id',
        ]);

        return DB::transaction(function () use ($request) {
            $jadwal = JadwalLapangan::with('lapangan')->findOrFail($request->jadwal_id);

            $mulai = Carbon::parse($jadwal->jam_mulai);
            $selesai = Carbon::parse($jadwal->jam_selesai);


            $durasiJam = $mulai->diffInMinutes($selesai) / 60;

            if ($jadwal->status_slot !== 'tersedia') {
                return back()->with('error', 'Maaf, jadwal ini baru saja dipesan orang lain.');
            }

            Booking::create([
                'user_id' => Auth::id(),
                'jadwal_lapangan_id' => $jadwal->id,
                'total_harga' => $jadwal->lapangan->harga_per_jam * $durasiJam,
                'metode_pembayaran' => 'cod',
                'status' => 'pending',
            ]);

            $jadwal->update(['status_slot' => 'dibooking']);

            return redirect('/user/booking')->with('success', 'Booking berhasil! Silahkan datang tepat waktu.');
        });
    }
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();


        return DB::transaction(function () use ($booking) {

            $jadwal = JadwalLapangan::find($booking->jadwal_lapangan_id);
            if ($jadwal) {
                $jadwal->update(['status_slot' => 'tersedia']);
            }

            $booking->update(['status' => 'dibatalkan']);

            return redirect()->back()->with('success', 'Booking telah dibatalkan.');
        });
    }
}
