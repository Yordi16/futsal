<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    public function index(User $user)
    {
        // proteksi admin
        abort_if(auth()->user()->role !== 'admin', 403);

        // ambil booking milik user 
        $bookings = $user->bookings()
            ->with('jadwalLapangan.lapangan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.daftaruser.detailorder', compact('user', 'bookings'));
    }
}
