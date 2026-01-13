<?php

namespace App\Http\Controllers; // Sesuaikan dengan web.php yang memanggil App\Http\Controllers\ReportController

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan utama
     * Route: admin.report.index
     */
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        // Hanya hitung pendapatan dari status 'booked' atau 'selesai'
        $query = Booking::whereIn('status', ['selesai'])
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

    /**
     * Export data ke PDF
     * Route: admin.report.pdf menggunakan method exportPdf
     */
    public function exportPdf(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = Booking::whereIn('status', ['booked', 'selesai'])
            ->with(['user', 'jadwalLapangan.lapangan']);

        if ($start && $end) {
            $query->whereHas('jadwalLapangan', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            });
        }

        $bookings = $query->get();
        $pdf = Pdf::loadView('admin.report.pdf', compact('bookings', 'start', 'end'));

        return $pdf->download('Laporan-Transaksi-Futsal.pdf');
    }

    /**
     * Export data ke Excel
     * Route: admin.report.excel menggunakan method exportExcel
     */
    public function exportExcel(Request $request)
    {
        // Memanggil BookingExport dengan filter tanggal
        return Excel::download(
            new BookingExport($request->start_date, $request->end_date),
            'Laporan-Booking-Futsal.xlsx'
        );
    }

    /**
     * Method untuk Chart
     * Route: /report/chart menggunakan method chart
     */
    public function chart(Request $request)
    {
        $total = $this->getChartData($request->start_date, $request->end_date);
        return response()->json($total);
    }

    /**
     * Helper untuk mengambil data grafik secara konsisten
     */
    private function getChartData($start, $end)
    {
        $query = Booking::whereIn('status', ['booked', 'selesai'])
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
