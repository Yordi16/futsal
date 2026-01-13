<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'jadwal_lapangan_id', 'total_harga', 'status', 'metode_pembayaran'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalLapangan()
    {
        return $this->belongsTo(JadwalLapangan::class, 'jadwal_lapangan_id');
    }

    public function lapangan()
    {
        return $this->hasOneThrough(
            Lapangan::class,
            JadwalLapangan::class,
            'id',
            'id',
            'jadwal_lapangan_id',
            'lapangan_id'
        );
    }
}
