<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        // Booking + relasi aman (user, jadwal, lapangan via jadwal)
        $bookings = Booking::with([
            'user',
            'jadwalLapangan.lapangan'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }

    public function update(Request $request, Booking $booking)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'status' => 'required|in:pending,booked,selesai'
        ]);

        // Update status booking
        $booking->update([
            'status' => $request->status
        ]);

        /**
         * Sinkron status slot jadwal
         * - booked   -> slot booked
         * - selesai  -> slot tersedia
         */
        if ($booking->jadwalLapangan) {
            if ($request->status === 'booked') {
                $booking->jadwalLapangan->update([
                    'status_slot' => 'dibooking'
                ]);
            }

            if ($request->status === 'selesai') {
                $booking->jadwalLapangan->update([
                    'status_slot' => 'tersedia'
                ]);
            }
        }

        return back()->with('success', 'Status booking berhasil diperbarui');
    }
}
