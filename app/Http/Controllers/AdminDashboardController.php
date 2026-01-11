<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use App\Models\Booking;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $totalLapangan = Lapangan::count();
        $totalBooking  = Booking::count();
        $totalPendapatan = Booking::sum('total_harga');

        $bookingTerbaru = Booking::with(['user', 'lapangan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLapangan',
            'totalBooking',
            'totalPendapatan',
            'bookingTerbaru'
        ));
    }
}
