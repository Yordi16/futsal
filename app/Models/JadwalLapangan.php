<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class JadwalLapangan extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lapangan_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status_slot'
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id')->withTrashed();
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
