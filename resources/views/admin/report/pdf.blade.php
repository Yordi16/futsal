<!DOCTYPE html>
<html>

<head>
    <title>Laporan Booking</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>

    <h2 align="center">Laporan Transaksi Booking Futsal</h2>

    <table>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Total</th>
        </tr>

        @foreach($bookings as $b)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->lapangan->nama_lapangan }}</td>
                <td>{{ $b->tanggal }}</td>
                <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                <td>Rp {{ number_format($b->total_harga) }}</td>
            </tr>
        @endforeach

    </table>

</body>

</html>