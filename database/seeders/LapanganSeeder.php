<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        Lapangan::insert([
            [
                'nama_lapangan' => 'Lapangan A',
                'jenis' => 'Vinyl',
                'harga_per_jam' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan B',
                'jenis' => 'Rumput Sintetis',
                'harga_per_jam' => 100000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan C',
                'jenis' => 'Vinyl',
                'harga_per_jam' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan D',
                'jenis' => 'Rumput Sintetis',
                'harga_per_jam' => 100000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
