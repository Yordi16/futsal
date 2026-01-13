<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $fillable = [
        'nama_lapangan',
        'jenis',
        'harga_per_jam',
        'status'
    ];

    public function jadwalLapangans()
    {
        return $this->hasMany(JadwalLapangan::class);
    }
}
