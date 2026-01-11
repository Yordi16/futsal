@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Lapangan</h1>

    <form action="{{ route('lapangan.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1">Harga per Jam</label>
            <input type="number" name="harga_per_jam" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1">Status</label>
            <select name="is_active" class="w-full border p-2 rounded">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('lapangan.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>
@endsection