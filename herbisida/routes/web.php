<?php

use App\Http\Controllers\AiScanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\PemakaianController;
use Illuminate\Support\Facades\Route;

// Redirect root ke beranda
Route::get('/', fn() => redirect()->route('beranda'));

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Proteksi Route dengan Middleware Auth
Route::middleware('auth')->group(function () {

    // Beranda
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    // Pekerjaan (Blok CRUD)
    Route::get('/pekerjaan',            [BlokController::class, 'index'])->name('pekerjaan.index');
    Route::post('/pekerjaan',           [BlokController::class, 'store'])->name('pekerjaan.store');
    Route::get('/pekerjaan/{block}',    [BlokController::class, 'show'])->name('pekerjaan.show');
    Route::put('/pekerjaan/{block}',    [BlokController::class, 'update'])->name('pekerjaan.update');
    Route::delete('/pekerjaan/{block}', [BlokController::class, 'destroy'])->name('pekerjaan.destroy');
    Route::post('/pekerjaan/{block}/selesai', [BlokController::class, 'selesai'])->name('pekerjaan.selesai');

    // Riwayat Pemakaian
    Route::get('/pekerjaan/{block}/riwayat',   [PemakaianController::class, 'index'])->name('pekerjaan.riwayat');
    Route::post('/pekerjaan/{block}/pemakaian', [PemakaianController::class, 'store'])->name('pekerjaan.pemakaian');

    // Evaluasi
    Route::get('/pekerjaan/{block}/evaluasi',  [EvaluasiController::class, 'create'])->name('pekerjaan.evaluasi');
    Route::post('/pekerjaan/{block}/evaluasi', [EvaluasiController::class, 'store'])->name('pekerjaan.evaluasi.store');
    Route::get('/pekerjaan/{block}/hasil',     fn($block) => view('pekerjaan.hasil', [
        'block' => App\Models\Block::with('evaluasi')->findOrFail($block->id ?? $block),
    ]))->name('pekerjaan.hasil');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Akun
    Route::get('/akun', fn() => view('akun.index'))->name('akun');

    // AI Scan API (AJAX)
    Route::post('/api/ai/scan-gulma',    [AiScanController::class, 'scanGulma'])->name('ai.scan-gulma');
    Route::post('/api/ai/scan-evaluasi', [AiScanController::class, 'scanEvaluasi'])->name('ai.scan-evaluasi');

});
