<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// redirect awal
Route::get('/', function () {
    return redirect('/login');
});

// setelah login redirect role
Route::get('/redirect', function () {
    if (Auth::user()->role == 'admin') {
        return redirect('/dashboard');
    } else {
        return redirect('/laporan');
    }
})->middleware(['auth']);

// group auth
Route::middleware(['auth'])->group(function () {

    // ================= DOSEN =================
    Route::middleware(['role:dosen'])->group(function () {

        // ❗ update DIHAPUS dari sini
        Route::resource('laporan', LaporanController::class)->except(['update']);

        Route::get('/history', [LaporanController::class, 'history'])->name('laporan.history');
    });

    // ================= ADMIN =================
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/laporan', [LaporanController::class, 'index']);

        // ✅ update khusus admin
        Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    });

    // ================= PROFILE =================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';