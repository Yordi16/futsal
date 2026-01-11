<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::where('status', 'tersedia')->get();
        return view('user.booking.index', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lapangan_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        $lapangan = Lapangan::findOrFail($request->lapangan_id);

        $jam = (strtotime($request->jam_selesai) - strtotime($request->jam_mulai)) / 3600;
        $total = $jam * $lapangan->harga_per_jam;

        // cek bentrok jam
        $bentrok = Booking::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($bentrok) {
            return back()->withErrors([
                'jam_mulai' => 'Jam booking bentrok, silakan pilih jam lain'
            ]);
        }


        Booking::create([
            'user_id' => auth()->id(),
            'lapangan_id' => $lapangan->id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_harga' => $total
        ]);

        return redirect()->back()->with('success', 'Booking berhasil');
    }
    public function history()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('lapangan')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('user.booking.history', compact('bookings'));
    }
}
