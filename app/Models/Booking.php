<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'jadwal_lapangan_id',
        'total_harga',
        'status',
        'metode_pembayaran'
    ];

    public function scopeSuccessful($query)
    {
        return $query->whereIn('status', ['selesai']);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function jadwalLapangan()
    {
        return $this->belongsTo(JadwalLapangan::class, 'jadwal_lapangan_id')->withTrashed();
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
