@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Data Lapangan</h1>

<a href="{{ route('lapangan.create') }}"
   class="inline-block mb-4 bg-blue-600 text-white px-4 py-2 rounded">
   + Tambah Lapangan
</a>

<table class="w-full border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="border p-2">Nama</th>
            <th class="border p-2">Harga / Jam</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lapangans as $l)
        <tr class="text-center">
            <td class="border p-2">{{ $l->nama_lapangan }}</td>
            <td class="border p-2">Rp {{ number_format($l->harga_per_jam) }}</td>
            <td class="border p-2">
                @if($l->is_active)
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                        Aktif
                    </span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">
                        Nonaktif
                    </span>
                @endif
            </td>
            <td class="border p-2 space-x-2">
                <a href="{{ route('lapangan.edit', $l->id) }}"
                   class="text-blue-600 hover:underline">
                   Edit
                </a>

                <form action="{{ route('lapangan.destroy', $l->id) }}"
                      method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus data?')"
                        class="text-red-600 hover:underline">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
