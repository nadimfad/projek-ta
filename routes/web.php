<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/welcome');
});

Route::get('/redirect', function () {
    if (in_array(session('active_role', Auth::user()->role), ['admin', 'kajur'], true)) {
        return redirect('/dashboard');
    }

    return redirect('/laporan');
})->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:dosen'])->group(function () {
        Route::resource('laporan', LaporanController::class)->except(['show', 'edit', 'update']);
        Route::get('/history', [LaporanController::class, 'history'])->name('laporan.history');
    });

Route::middleware(['role:admin,kajur'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/dosen-pelapor', [DashboardController::class, 'dosenPelapor'])->name('dashboard.dosen-pelapor');

    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');

    Route::get('/admin/statistik', [DashboardController::class, 'statistik'])->name('admin.statistik');

    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');

    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');
});

Route::middleware(['role:admin'])->group(function () {
    // USER MANAGEMENT
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');

    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');

    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');

    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
