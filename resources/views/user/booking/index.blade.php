@extends('user.layout') {{-- Pastikan nama file layout sesuai --}}

@section('content')
<div class="w-full">
    {{-- Header Halaman --}}
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Booking Lapangan</h2>
        <p class="text-gray-500 mt-1">Silakan isi formulir di bawah untuk memesan jadwal pertandingan.</p>
    </div>

    {{-- Container Form --}}
    {{-- Diubah dari max-w-lg ke max-w-2xl agar lebih nyaman di mata setelah ada sidebar --}}
    <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Progress Bar dekoratif (Opsional) --}}
        <div class="h-2 w-full bg-gray-100">
            <div class="h-full bg-blue-600 w-1/3"></div>
        </div>

        <div class="p-8">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3"></i>
                    <p class="text-sm font-bold">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="/user/booking" class="space-y-6">
                @csrf

                {{-- Pilih Lapangan --}}
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <i class="fas fa-map-marker-alt mr-1"></i> Pilih Lapangan
                    </label>
                    <select name="lapangan_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white outline-none transition duration-200 appearance-none">
                        @foreach($lapangans as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->nama_lapangan }} — {{ $l->jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="group">
                    <label class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                        <i class="fas fa-calendar-alt mr-1"></i> Tanggal Main
                    </label>
                    <input type="date" name="tanggal" class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white outline-none transition duration-200">
                </div>

                {{-- Grid Jam --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <label class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                            <i class="fas fa-clock mr-1"></i> Jam Mulai
                        </label>
                        <input type="time" name="jam_mulai" class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white outline-none transition duration-200">
                    </div>
                    <div class="group">
                        <label class="block text-sm font-bold text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
                            <i class="fas fa-stopwatch mr-1"></i> Jam Selesai
                        </label>
                        <input type="time" name="jam_selesai" class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 focus:bg-white outline-none transition duration-200">
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="pt-4">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 px-6 rounded-xl shadow-blue-200 shadow-lg transform active:scale-[0.97] transition-all duration-150 flex items-center justify-center space-x-2">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Konfirmasi & Buat Pesanan</span>
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4 italic">
                        *Pastikan jadwal yang Anda pilih tidak bentrok dengan riwayat booking.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection