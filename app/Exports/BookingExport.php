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

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = Booking::successful()
            ->with(['user', 'jadwalLapangan.lapangan']);

        if ($this->start && $this->end) {
            $query->whereHas('jadwalLapangan', function ($q) {
                $q->whereBetween('tanggal', [$this->start, $this->end]);
            });
        }

        return $query->latest()->get();
    }

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

    public function map($booking): array
    {
        return [
            '#BK-' . $booking->id,
            $booking->user->name ?? 'User Terhapus',
            $booking->jadwalLapangan->lapangan->nama_lapangan ?? '-',
            $booking->jadwalLapangan->tanggal,
            substr($booking->jadwalLapangan->jam_mulai, 0, 5) . ' - ' . substr($booking->jadwalLapangan->jam_selesai, 0, 5),
            $booking->total_harga,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
            ],
        ];
    }
}
