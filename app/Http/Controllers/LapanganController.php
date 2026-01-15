<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $lapangans = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255|unique:lapangans,nama_lapangan',
            'jenis'         => 'required|in:Rumput Sintetis,Vinyl',
            'harga_per_jam' => 'required|numeric|min:0',
        ], [
            'nama_lapangan.unique' => 'Nama lapangan sudah terdaftar'
        ]);

        $validated['status'] = 'tersedia';
        Lapangan::create($validated);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan baru berhasil ditambahkan');
    }

    public function edit(Lapangan $lapangan)
    {
        $this->authorizeAdmin();
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255|unique:lapangans,nama_lapangan,' . $lapangan->id,
            'jenis'         => 'required|in:Rumput Sintetis,Vinyl',
            'harga_per_jam' => 'required|numeric|min:0',
            'status'        => 'required|in:tersedia,tidak tersedia'
        ], [
            'nama_lapangan.unique' => 'Nama Lapangan sudah terdaftar.'
        ]);

        $lapangan->update($validated);
        return redirect()->route('lapangan.index')->with('success', 'Data Lapangan berhasil diupdate');
    }


    public function destroy(Lapangan $lapangan)
    {
        $this->authorizeAdmin();

        $lapangan->delete();

        return redirect()->route('lapangan.index')
            ->with('success', 'Data Lapangan berhasil dihapus');
    }

    private function authorizeAdmin()
    {
        return abort_if(auth()->user()->role !== 'admin', 403, 'Akses ditolak. Anda bukan admin.');
    }
}
