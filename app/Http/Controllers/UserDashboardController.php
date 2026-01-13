<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\JadwalLapangan;
use App\Models\Booking;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        // Jumlah booking mendatang (booked)
        $upcomingCount = Booking::where('user_id', $userId)
            ->where('status', 'booked')
            ->count();

        // Total main yang sudah selesai
        $totalMainCount = Booking::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        // 5 riwayat booking terbaru
        $recentBookings = Booking::with(['jadwalLapangan.lapangan'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('upcomingCount', 'totalMainCount', 'recentBookings'));
    }

    public function lapangan()
    {
        $lapangans = Lapangan::all();
        return view('user.lapangan', compact('lapangans'));
    }

    public function jadwal($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        // Ambil jadwal yang tersedia untuk lapangan ini
        // Kita urutkan berdasarkan tanggal dan jam mulai
        $jadwals = JadwalLapangan::where('lapangan_id', $id)
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('user.jadwal', compact('lapangan', 'jadwals'));
    }

    public function booking()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with(['jadwalLapangan.lapangan'])
            ->latest()
            ->get();

        return view('user.booking', compact('bookings'));
    }
}
