<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\JadwalLapangan;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'admin')->first();
        $jadwal = JadwalLapangan::first();

        if (!$user || !$jadwal) {
            throw new \Exception('User admin atau Jadwal Lapangan belum ada');
        }

        Booking::create([
            'user_id' => $user->id,
            'jadwal_lapangan_id' => $jadwal->id,
            'total_harga' => 120000,
            'status_slot' => 'booked',
            'metode_pembayaran' => 'cash',
        ]);
    }
}
