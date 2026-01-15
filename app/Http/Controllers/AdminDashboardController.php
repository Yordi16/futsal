<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\Booking;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $totalLapangan = Lapangan::count();
        $totalBooking  = Booking::count();

        $totalPendapatan = Booking::successful()->sum('total_harga');

        $bookingTerbaru = Booking::with(['user', 'jadwalLapangan.lapangan'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('totalLapangan', 'totalBooking', 'totalPendapatan', 'bookingTerbaru'));
    }
}
