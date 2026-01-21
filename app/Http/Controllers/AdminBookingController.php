<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

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
            'status' => 'required|in:pending,booked,selesai,dibatalkan'
        ]);

        return DB::transaction(function () use ($request, $booking) {
            $booking->update([
                'status' => $request->status
            ]);

            if ($booking->jadwalLapangan) {
                if (in_array($request->status, ['booked', 'pending'])) {
                    $booking->jadwalLapangan->update(['status_slot' => 'dibooking']);
                }

                if (in_array($request->status, ['dibatalkan'])) {
                    $booking->jadwalLapangan->update(['status_slot' => 'tersedia']);
                }
            }

            return back()->with('success', 'Status booking berhasil diperbarui');
        });
    }
}
