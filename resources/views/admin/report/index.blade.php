@extends('layout')

@section('content')
    <h2>Laporan Transaksi</h2>

    <a href="/admin/report/pdf">Export PDF</a>
    |
    <a href="/admin/report/excel">Export Excel</a>

    <table border="1">
        <tr>
            <th>User</th>
            <th>Lapangan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Total</th>
        </tr>

        @foreach($bookings as $b)
            <tr>
                <td>{{ $b->user->name }}</td>
                <td>{{ $b->lapangan->nama_lapangan }}</td>
                <td>{{ $b->tanggal }}</td>
                <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                <td>Rp {{ number_format($b->total_harga) }}</td>
            </tr>
        @endforeach
    </table>
    <h3>Grafik Pendapatan</h3>
    <ul>
        @foreach($total as $t)
            <li>{{ $t->tanggal }} : Rp {{ number_format($t->total) }}</li>
        @endforeach
    </ul>

@endsection