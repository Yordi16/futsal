<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KelolaUserController extends Controller
{
    public function index()
    {
        // proteksi admin
        abort_if(auth()->user()->role !== 'admin', 403);

        // ambil semua user dari tabel users
        $users = User::where('role', 'user')
        ->latest()
        ->paginate(10);

        // kirim ke view
        return view('admin.daftaruser.index', compact('users'));
    }
    
}
