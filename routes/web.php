<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ManajemenPengajuanController;
use App\Http\Controllers\PengajuanKreditController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanySettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/motor/{motor}/ajukan', [PengajuanKreditController::class, 'show'])->name('pengajuan.form');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin,marketing,surveyor,kolektor,manager,owner'])
    ->name('dashboard');

Route::get('/monitoring', [DashboardController::class, 'monitoring'])
    ->middleware(['auth', 'verified', 'role:manager,owner'])
    ->name('monitoring');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/motor/{motor}/ajukan', [PengajuanKreditController::class, 'store'])->name('pengajuan.store');
    
    // Client Area
    Route::get('/pengajuan-saya', [\App\Http\Controllers\ClientAreaController::class, 'pengajuan'])->name('client.pengajuan');
    Route::get('/pengajuan-saya/{pengajuan}/bayar', [\App\Http\Controllers\ClientAreaController::class, 'bayar'])->name('client.bayar');
    // AJAX endpoint: dipanggil JS onSuccess dari Snap.js
    Route::post('/pengajuan-saya/{pengajuan}/bayar/konfirmasi', [\App\Http\Controllers\ClientAreaController::class, 'konfirmasiBayar'])->name('client.bayar.konfirmasi');
    // GET: Midtrans finish redirect → verifikasi server-side via Midtrans API
    Route::get('/pengajuan-saya/{pengajuan}/bayar/selesai', [\App\Http\Controllers\ClientAreaController::class, 'selesaiBayar'])->name('client.bayar.selesai');
    Route::get('/pengajuan-saya/{pengajuan}/sukses', [\App\Http\Controllers\ClientAreaController::class, 'suksesBayar'])->name('client.bayar.sukses');
    
    // Tagihan / Angsuran Bulanan
    Route::get('/tagihan-saya', [\App\Http\Controllers\ClientAreaController::class, 'tagihan'])->name('client.tagihan');
    Route::get('/tagihan-saya/{angsuran}/bayar', [\App\Http\Controllers\ClientAreaController::class, 'bayarAngsuran'])->name('client.angsuran.bayar');
    Route::post('/tagihan-saya/{angsuran}/bayar/konfirmasi', [\App\Http\Controllers\ClientAreaController::class, 'konfirmasiAngsuran'])->name('client.angsuran.konfirmasi');
    Route::get('/tagihan-saya/{angsuran}/bayar/selesai', [\App\Http\Controllers\ClientAreaController::class, 'selesaiAngsuran'])->name('client.angsuran.selesai');
});

Route::middleware(['auth', 'role:admin,owner'])->group(function () {
    Route::resource('motor', \App\Http\Controllers\MotorController::class)->except(['show']);
    Route::resource('banner', \App\Http\Controllers\BannerController::class)->except(['show']);
    Route::get('/perusahaan', [CompanySettingController::class, 'edit'])->name('company.edit');
    Route::put('/perusahaan', [CompanySettingController::class, 'update'])->name('company.update');
});

Route::middleware(['auth', 'role:marketing,kolektor,owner'])->group(function () {
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{angsuran}/bayar', [PembayaranController::class, 'store'])->name('pembayaran.store');
});

Route::middleware(['auth', 'role:marketing,surveyor,kolektor,owner'])->group(function () {
    Route::get('/pengajuan', [ManajemenPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [ManajemenPengajuanController::class, 'show'])->name('pengajuan.show');
});

Route::middleware(['auth', 'role:marketing,owner'])->group(function () {
    Route::post('/pengajuan/{pengajuan}/status', [ManajemenPengajuanController::class, 'updateStatus'])->name('pengajuan.update-status');
    Route::delete('/pengajuan/{pengajuan}', [ManajemenPengajuanController::class, 'destroy'])->name('pengajuan.destroy');

    // Manajemen Kredit Aktif
    Route::get('/kredit', [\App\Http\Controllers\ManajemenKreditController::class, 'index'])->name('kredit.index');
    Route::get('/kredit/{kredit}', [\App\Http\Controllers\ManajemenKreditController::class, 'show'])->name('kredit.show');
    Route::post('/kredit/aktivasi/{pengajuan}', [\App\Http\Controllers\ManajemenKreditController::class, 'aktivasi'])->name('kredit.aktivasi');
});

require __DIR__.'/auth.php';
