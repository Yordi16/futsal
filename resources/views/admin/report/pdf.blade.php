<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Booking Ari Futsal</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            text-transform: uppercase;
            font-size: 18px;
            color: #1a1a1a;
        }

        .range {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            border: 1px solid #dee2e6;
            padding: 10px 8px;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: middle;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Baris Total */
        .total-row {
            background-color: #f1f5f9;
            font-size: 12px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Transaksi Booking</h2>
        <div class="range">
            @if ($start && $end)
                Periode: <strong>{{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }}</strong>
                s/d
                <strong>{{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}</strong>
            @else
                Semua Periode Transaksi
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama User</th>
                <th width="20%">Lapangan</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Sesi Jam</th>
                <th width="20%">Nominal Bayar</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach ($bookings as $b)
                @php $grandTotal += $b->total_harga; @endphp
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $b->user->name ?? 'User Terhapus' }}</strong></td>
                    <td>{{ $b->lapangan->nama_lapangan ?? '-' }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($b->jadwalLapangan->tanggal)->format('d/m/Y') }}</td>
                    <td class="center">
                        {{ $b->jadwalLapangan->jam_mulai }} - {{ $b->jadwalLapangan->jam_selesai }}
                    </td>
                    <td class="right">
                        Rp {{ number_format($b->total_harga, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="right font-bold">TOTAL PENDAPATAN BERSIH :</td>
                <td class="right font-bold" style="color: #059669;">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}
    </div>

</body>

</html>