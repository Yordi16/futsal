<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $lapangans = Lapangan::all();
        return view('admin.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        return view('admin.lapangan.create');
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'nama_lapangan' => 'required',
            'jenis' => 'required',
            'harga_per_jam' => 'required|numeric',
            'status' => 'required'
        ]);

        Lapangan::create($request->all());
        return redirect()->route('lapangan.index');
    }

    public function edit(Lapangan $lapangan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $request->validate([
            'nama_lapangan' => 'required',
            'jenis' => 'required',
            'harga_per_jam' => 'required|numeric',
            'status' => 'required'
        ]);

        $lapangan->update($request->all());
        return redirect()->route('lapangan.index')
            ->with('success', 'Data Lapangan berhasil diupdate');
    }


    public function destroy(Lapangan $lapangan)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $lapangan->delete();
        return redirect()->route('lapangan.index')
            ->with('success', 'Data Lapangan berhasil dihapus');
    }
}
