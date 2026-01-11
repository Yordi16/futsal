@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-blue-500 text-white p-4 rounded">
        <h2 class="text-lg">Total Lapangan</h2>
        <p class="text-3xl font-bold">
            {{ \App\Models\Lapangan::count() }}
        </p>
    </div>
</div>
@endsection
