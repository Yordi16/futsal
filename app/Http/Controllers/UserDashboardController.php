<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\JadwalLapangan;
use App\Models\Booking;
use Carbon\Carbon;


class UserDashboardController extends Controller
{
    public function dashboard()
    {
        $userId = auth()->id();

        $upcomingCount = Booking::where('user_id', $userId)
            ->where('status', 'booked')
            ->count();

        $totalMainCount = Booking::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

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

        $now = Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();

        $jadwals = JadwalLapangan::where('lapangan_id', $id)
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tanggal', '>', $today)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tanggal', $today)
                            ->where('jam_mulai', '>', $currentTime);
                    });
            })
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->map(function ($jadwal) use ($lapangan) {
                $mulai = Carbon::parse($jadwal->jam_mulai);
                $selesai = Carbon::parse($jadwal->jam_selesai);

                $durasi = $mulai->diffInMinutes($selesai) / 60;
                $jadwal->durasi = $durasi;
                $jadwal->total_harga = $durasi * $lapangan->harga_per_jam;

                return $jadwal;
            });

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
