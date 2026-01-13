<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\JadwalLapangan;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * LIST LAPANGAN UNTUK BOOKING
     */
    public function index()
    {
        $lapangans = Lapangan::where('status', 'tersedia')->get();

        return view('user.booking', compact('lapangans'));
    }

    /**
     * PROSES BOOKING
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_lapangans,id',
        ]);

        $jadwal = JadwalLapangan::findOrFail($request->jadwal_id);

        // 1. Cek apakah jadwal masih tersedia (keamanan ganda)
        if ($jadwal->status_slot !== 'tersedia') {
            return back()->with('error', 'Maaf, jadwal ini baru saja dipesan orang lain.');
        }

        // 2. Buat data Booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'jadwal_lapangan_id' => $jadwal->id,
            'total_harga' => $jadwal->lapangan->harga_per_jam,
            'metode_pembayaran' => 'cod',
            'status' => 'pending', // Status awal pending sampai admin konfirmasi di lapangan
        ]);

        // 3. Update status jadwal agar tidak muncul lagi di daftar
        $jadwal->update(['status_slot' => 'dibooking']);

        return redirect('/user/booking')->with('success', 'Booking berhasil! Silahkan bayar di kasir saat hari H.');
    }
}
