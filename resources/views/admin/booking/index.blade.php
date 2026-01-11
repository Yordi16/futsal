@extends('layout')

@section('content')
    <h2>Data Booking (Admin)</h2>

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
@endsection