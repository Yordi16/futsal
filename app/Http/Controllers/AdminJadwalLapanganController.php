<?php

namespace App\Http\Controllers;

use App\Models\JadwalLapangan;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminJadwalLapanganController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $jadwals = JadwalLapangan::with(['lapangan' => function ($q) {
            $q->withTrashed();
        }])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        $lapangans = Lapangan::all();

        return view('admin.jadwal.index', compact('jadwals', 'lapangans'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $lapangans = Lapangan::all();
        return view('admin.jadwal.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal'     => 'required|date|after_or_equal:today',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $bentrok = JadwalLapangan::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->jam_selesai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })->exists();

        if ($bentrok) {
            return back()->withInput()->withErrors(['jadwal' => 'Gagal! Jam tersebut bentrok dengan jadwal lain yang sudah ada.']);
        }

        JadwalLapangan::create($validated + ['status_slot' => 'tersedia']);
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(JadwalLapangan $jadwal)
    {
        $this->authorizeAdmin();

        $lapangans = Lapangan::all();
        return view('admin.jadwal.edit', compact('jadwal', 'lapangans'));
    }

    public function update(Request $request, JadwalLapangan $jadwal)
    {
        $this->authorizeAdmin();

        if ($jadwal->status_slot === 'dibooking') {
            return back()->withErrors(['jadwal' => 'Jadwal ini sudah dibooking pelanggan.']);
        }

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status_slot' => 'required|in:tersedia,tidak tersedia',
        ]);


        $isWaktuBerubah =
            $request->lapangan_id != $jadwal->lapangan_id ||
            $request->tanggal     != $jadwal->tanggal ||
            $request->jam_mulai   != $jadwal->jam_mulai ||
            $request->jam_selesai != $jadwal->jam_selesai;


        if ($isWaktuBerubah) {
            $bentrok = JadwalLapangan::where('lapangan_id', $request->lapangan_id)
                ->where('tanggal', $request->tanggal)
                ->where('id', '!=', $jadwal->id) // Tetap kecualikan diri sendiri
                ->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_selesai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                })->exists();

            if ($bentrok) {
                return back()->withInput()->withErrors(['jadwal' => 'Gagal update! Jam tersebut bentrok dengan jadwal lain.']);
            }
        }


        $jadwal->update($validated);

        return redirect()
            ->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(JadwalLapangan $jadwal)
    {
        $this->authorizeAdmin();

        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }

    public function generate(Request $request)
    {

        $durasi = (int) $request->durasi;
        $tanggal = $request->tanggal;
        $jam_mulai_iterasi = Carbon::parse($request->jam_buka);
        $jam_tutup_operasional = Carbon::parse($request->jam_tutup);

        $countSuccess = 0;
        $countFail = 0;


        while ($jam_mulai_iterasi->copy()->addHours($durasi) <= $jam_tutup_operasional) {
            $jam_selesai_slot = $jam_mulai_iterasi->copy()->addHours($durasi);

            $mulaiStr = $jam_mulai_iterasi->format('H:i:s');
            $selesaiStr = $jam_selesai_slot->format('H:i:s');


            $isBentrok = JadwalLapangan::where('lapangan_id', $request->lapangan_id)
                ->where('tanggal', $tanggal)
                ->where(function ($query) use ($mulaiStr, $selesaiStr) {

                    $query->where('jam_mulai', '<', $selesaiStr)
                        ->where('jam_selesai', '>', $mulaiStr);
                })->exists();

            if (!$isBentrok) {
                JadwalLapangan::create([
                    'lapangan_id' => $request->lapangan_id,
                    'tanggal'     => $tanggal,
                    'jam_mulai'   => $mulaiStr,
                    'jam_selesai' => $selesaiStr,
                    'status_slot' => 'tersedia',
                ]);
                $countSuccess++;
            } else {
                $countFail++;
            }


            $jam_mulai_iterasi->addHours($durasi);
        }

        if ($countSuccess > 0) {
            return redirect()->route('admin.jadwal.index')
                ->with('success', "$countSuccess jadwal berhasil ditambahkan. " . ($countFail > 0 ? "$countFail jadwal bentrok dilewati." : ""));
        }

        return redirect()->back()->with('error', 'Semua jadwal pada jam tersebut sudah terisi (bentrok).');
    }


    private function authorizeAdmin()
    {
        return abort_if(auth()->user()->role !== 'admin', 403, 'Akses ditolak.');
    }
}
