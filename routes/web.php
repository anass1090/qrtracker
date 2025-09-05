<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use App\Http\Controllers\QrAdminController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('qrs', QrAdminController::class)->except(['edit', 'update']);
    Route::get('qrs/{qr}/download', [QrAdminController::class, 'download'])->name('qrs.download');
    Route::get('qrs/{qr}/stats.json', [QrController::class, 'stats'])->name('qrs.stats.json');
});

Route::get('/qr/{slug}', [QrController::class, 'scan'])->name('qr.scan');

require __DIR__.'/auth.php';
