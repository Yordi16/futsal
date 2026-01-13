<?php

namespace App\Http\Controllers;

use App\Models\JadwalLapangan;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class AdminJadwalLapanganController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $jadwals = JadwalLapangan::with('lapangan')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $lapangans = Lapangan::all();
        return view('admin.jadwal.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'lapangan_id' => 'required',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // CEK JADWAL BENTROK
        $bentrok = JadwalLapangan::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jadwal' => 'Jam tersebut sudah terisi jadwal lain!']);
        }

        JadwalLapangan::create($request->all() + ['status_slot' => 'tersedia']);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal ditambahkan');
    }

    public function edit(JadwalLapangan $jadwal)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $lapangans = Lapangan::all();
        return view('admin.jadwal.edit', compact('jadwal', 'lapangans'));
    }

    public function update(Request $request, JadwalLapangan $jadwal)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status_slot' => 'required|in:tersedia,booked',
        ]);

        $jadwal->update([
            'lapangan_id' => $request->lapangan_id,
            'tanggal'     => $request->tanggal,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status_slot' => $request->status_slot,
        ]);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalLapangan $jadwal)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}
