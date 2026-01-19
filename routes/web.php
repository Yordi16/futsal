<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminJadwalLapanganController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect('/login');
});

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('lapangan', LapanganController::class);

    Route::get('/jadwal', [AdminJadwalLapanganController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/jadwal/create', [AdminJadwalLapanganController::class, 'create'])->name('admin.jadwal.create');
    Route::post('/jadwal', [AdminJadwalLapanganController::class, 'store'])->name('admin.jadwal.store');
    Route::post('/admin/jadwal/generate', [AdminJadwalLapanganController::class, 'generate'])->name('admin.jadwal.generate');
    Route::get('/jadwal/{jadwal}/edit', [AdminJadwalLapanganController::class, 'edit'])->name('admin.jadwal.edit');
    Route::put('/jadwal/{jadwal}', [AdminJadwalLapanganController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/jadwal/{jadwal}', [AdminJadwalLapanganController::class, 'destroy'])->name('admin.jadwal.destroy');

    Route::get('/booking', [AdminBookingController::class, 'index'])->name('admin.booking.index');
    Route::put('/booking/{booking}', [AdminBookingController::class, 'update'])->name('admin.booking.update');

    Route::get('/report', [ReportController::class, 'index'])->name('admin.report.index');
    Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('admin.report.pdf');
    Route::get('/report/excel', [ReportController::class, 'exportExcel'])->name('admin.report.excel');
    Route::get('/report/chart', [ReportController::class, 'chart'])->name('admin.report.chart');
});

//User
Route::middleware(['auth'])->prefix('user')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/lapangan', [UserDashboardController::class, 'lapangan'])->name('user.lapangan');
    Route::get('/jadwal/{id}', [UserDashboardController::class, 'jadwal'])->name('user.jadwal');

    Route::get('/booking', [UserDashboardController::class, 'booking'])->name('user.booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('user.booking.store');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('user.booking.cancel');
});
