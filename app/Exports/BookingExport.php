<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $start, $end;

    // Menangkap filter tanggal dari controller
    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * AKTIVASI LOGIKA UTAMA: 
     * Hanya mengambil status 'booked' dan 'selesai' untuk laporan pendapatan.
     */
    public function collection()
    {
        $query = Booking::whereIn('status', ['booked', 'selesai'])
            ->with(['user', 'jadwal.lapangan']);

        if ($this->start && $this->end) {
            $query->whereHas('jadwal', function ($q) {
                $q->whereBetween('tanggal', [$this->start, $this->end]);
            });
        }

        return $query->latest()->get();
    }

    // Header Excel
    public function headings(): array
    {
        return [
            'ID BOOKING',
            'NAMA PELANGGAN',
            'LAPANGAN',
            'TANGGAL',
            'WAKTU',
            'TOTAL HARGA'
        ];
    }

    // Mapping agar data rapi saat dibaca di Excel
    public function map($booking): array
    {
        return [
            '#BK-' . $booking->id,
            $booking->user->name ?? 'User Terhapus',
            $booking->jadwal->lapangan->nama_lapangan ?? '-',
            $booking->jadwal->tanggal,
            $booking->jadwal->jam_mulai . ' - ' . $booking->jadwal->jam_selesai,
            $booking->total_harga, // Format angka murni agar bisa di-SUM di Excel
        ];
    }

    // Memberikan style pada header agar profesional
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}
