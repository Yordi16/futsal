<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jadwal_lapangan_id')->constrained()->cascadeOnDelete();
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'booked', 'selesai', 'dibatalkan'])->default('pending');
            $table->enum('metode_pembayaran', ['cod'])->default('cod');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
