@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-bold mb-4">Edit Lapangan</h1>

<form action="{{ route('lapangan.update', $lapangan->id) }}"
      method="POST" class="space-y-4">
@csrf
@method('PUT')

<div>
    <label class="block mb-1">Nama Lapangan</label>
    <input type="text" name="nama_lapangan"
           value="{{ $lapangan->nama_lapangan }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block mb-1">Harga per Jam</label>
    <input type="number" name="harga_per_jam"
           value="{{ $lapangan->harga_per_jam }}"
           class="w-full border p-2 rounded">
</div>

<div>
    <label class="block mb-1">Status</label>
    <select name="is_active" class="w-full border p-2 rounded">
        <option value="1" {{ $lapangan->is_active ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ !$lapangan->is_active ? 'selected' : '' }}>Nonaktif</option>
    </select>
</div>

<div class="flex gap-2">
    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update
    </button>
    <a href="{{ route('lapangan.index') }}"
       class="bg-gray-400 text-white px-4 py-2 rounded">
        Kembali
    </a>
</div>

</form>
@endsection
