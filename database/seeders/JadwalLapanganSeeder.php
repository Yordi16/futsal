<?php

namespace Database\Seeders;

use App\Models\JadwalLapangan;
use Illuminate\Database\Seeder;

class JadwalLapanganSeeder extends Seeder
{
    public function run(): void
    {
        JadwalLapangan::insert([
            [
                'lapangan_id' => 1,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lapangan_id' => 1,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lapangan_id' => 2,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lapangan_id' => 2,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lapangan_id' => 3,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'lapangan_id' => 3,
                'tanggal' => now()->toDateString(),
                'jam_mulai' => '09:00',
                'jam_selesai' => '10:00',
                'status_slot' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
