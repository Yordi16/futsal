<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'store']);

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/admin/dashboard', function () {
        abort_if(auth()->user()->role != 'admin', 403);
        return view('admin.dashboard');
    });

    Route::get('/user/dashboard', function () {
        abort_if(auth()->user()->role != 'user', 403);
        return view('user.dashboard');
    });
});

// //admin lapangan 
// Route::resource('/admin/lapangan', LapanganController::class);

//BOOKING
//user
Route::get('/user/booking', [BookingController::class, 'index']);
Route::post('/user/booking', [BookingController::class, 'store']);
Route::get('/user/booking/history', [BookingController::class, 'history']);
//admin
Route::get('/admin/booking', [AdminBookingController::class, 'index']);

//report admin
Route::get('/admin/report', [ReportController::class, 'index']);

//export excel
Route::get('/admin/report/excel', [ReportController::class, 'exportExcel']);

//export pdf
Route::get('/admin/report/pdf', [ReportController::class, 'exportPdf']);


// //dasboard admin
// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);
Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('/admin/lapangan', LapanganController::class)
        ->names([
            'index'   => 'lapangan.index',
            'create'  => 'lapangan.create',
            'store'   => 'lapangan.store',
            'edit'    => 'lapangan.edit',
            'update'  => 'lapangan.update',
            'destroy' => 'lapangan.destroy',
        ]);
});
