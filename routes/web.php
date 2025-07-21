<?php

use Illuminate\Support\Facades\Route;

// Controller yang berada di luar folder Admin
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ExportController;

// Controller yang berada DI DALAM folder Admin
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik & Redirect
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rute Dashboard Utama
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// =========================================================================
// == GRUP RUTE UNTUK SEMUA USER YANG SUDAH LOGIN (ADMIN & SUPERADMIN) ==
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('permintaan', PermintaanController::class)->except(['edit', 'update']);
    
    Route::get('/pengambilan', [PengambilanController::class, 'index'])->name('pengambilan.index');
    Route::post('/pengambilan', [PengambilanController::class, 'store'])->name('pengambilan.store');

    Route::get('/riwayat-saya', [RiwayatController::class, 'userHistory'])->name('riwayat.user');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    
});


// =========================================================================
// == GRUP RUTE KHUSUS UNTUK SUPER ADMIN ==
// =========================================================================
Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute ini sekarang menunjuk ke controller di dalam folder Admin
    Route::resource('users', UserManagementController::class);

    // Rute ini menunjuk ke controller di luar folder Admin
    Route::resource('alat', AlatController::class);
    
    // Rute Approval Permintaan
    Route::get('/permintaan', [PermintaanController::class, 'adminIndex'])->name('permintaan.index');
    Route::patch('/permintaan/{permintaan}/approve', [PermintaanController::class, 'approve'])->name('permintaan.approve');
    Route::patch('/permintaan/{permintaan}/reject', [PermintaanController::class, 'reject'])->name('permintaan.reject');

    // Rute untuk melihat SEMUA riwayat transaksi
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // RUTE BARU UNTUK EKSPOR EXCEL
    Route::get('/riwayat/export', [ExportController::class, 'exportAllHistory'])->name('riwayat.export');
});


// Rute Otentikasi Bawaan Breeze
require __DIR__.'/auth.php';