<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Booking;
use App\Models\JadwalLapangan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $totalLapangan = Lapangan::count();
        $totalBooking  = Booking::count();

        // HANYA MENGHITUNG YANG SUKSES
        $totalPendapatan = Booking::whereIn('status', ['selesai'])->sum('total_harga');

        $bookingTerbaru = Booking::with(['user', 'jadwalLapangan.lapangan'])
            ->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('totalLapangan', 'totalBooking', 'totalPendapatan', 'bookingTerbaru'));
    }
}
