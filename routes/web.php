<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Guest Photo Download Routes (Mobile QR Destination)
Route::prefix('s')->group(function () {
    Route::get('/{slug}', [GuestController::class, 'show'])->name('guest.session');
    Route::get('/{slug}/view/{photoId}', [GuestController::class, 'viewPhoto'])->name('guest.view.photo');
    Route::get('/{slug}/download/{photoId}', [GuestController::class, 'downloadPhoto'])->name('guest.download.photo');
    Route::get('/{slug}/download-zip', [GuestController::class, 'downloadZip'])->name('guest.download.zip');
});

// Admin Dashboard Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [DashboardController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [DashboardController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::delete('/sessions/{id}', [DashboardController::class, 'deleteSession'])->name('admin.session.delete');
    Route::get('/events/{eventId}/backup', [DashboardController::class, 'backupEvent'])->name('admin.backup.event');
});
