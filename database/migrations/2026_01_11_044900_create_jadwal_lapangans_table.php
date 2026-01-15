<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('jadwal_lapangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status_slot', ['tersedia', 'dibooking', 'tidak tersedia'])->default('tersedia');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_lapangans');
    }
};
