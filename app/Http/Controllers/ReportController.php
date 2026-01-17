<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $start = $request->start_date;
        $end = $request->end_date;

        $query = Booking::successful()
            ->with(['user', 'jadwalLapangan.lapangan']);

        if ($start && $end) {
            $query->whereHas('jadwalLapangan', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            });
        }

        $bookings = $query->latest()->get();
        $total = $this->getChartData($start, $end);

        return view('admin.report.index', compact('bookings', 'total', 'start', 'end'));
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = Booking::successful()
            ->with(['user', 'jadwalLapangan.lapangan']);

        if ($start && $end) {
            $query->whereHas('jadwalLapangan', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            });
        }

        $bookings = $query->get();
        $pdf = Pdf::loadView('admin.report.pdf', compact('bookings', 'start', 'end'));

        return $pdf->download('Laporan-Transaksi-Ari-Futsal.pdf');
    }

    public function exportExcel(Request $request)
    {

        return Excel::download(
            new BookingExport($request->start_date, $request->end_date),
            'Laporan-Booking-Ari-Futsal.xlsx'
        );
    }

    public function chart(Request $request)
    {
        $total = $this->getChartData($request->start_date, $request->end_date);
        return response()->json($total);
    }

    private function getChartData($start, $end)
    {
        $query = Booking::successful()
            ->join('jadwal_lapangans', 'bookings.jadwal_lapangan_id', '=', 'jadwal_lapangans.id')
            ->select(
                DB::raw('DATE(jadwal_lapangans.tanggal) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc');

        if ($start && $end) {
            $query->whereBetween('jadwal_lapangans.tanggal', [$start, $end]);
        }

        return $query->get();
    }
}
