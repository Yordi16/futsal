<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $bookings = Booking::with(['user', 'lapangan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $total = Booking::selectRaw('tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->get();

        return view('admin.report.index', compact('bookings', 'total'));
    }


    public function exportExcel()
    {
        return Excel::download(new BookingExport, 'laporan-booking.xlsx');
    }


    public function exportPdf()
    {
        abort_if(auth()->user()->role !== 'admin', 403);

        $bookings = Booking::with(['user', 'lapangan'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.report.pdf', compact('bookings'));
        return $pdf->download('laporan-booking.pdf');
    }
}
