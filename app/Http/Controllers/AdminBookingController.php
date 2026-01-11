<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $bookings = Booking::with(['user', 'lapangan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }
}
