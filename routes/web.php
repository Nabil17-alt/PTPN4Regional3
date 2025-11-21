<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KalkulatorController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    $user = Auth::user();
    return view('dashboard', ['user' => $user]);
})->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/akun', [AdminController::class, 'akun'])->name('admin.akun');
    Route::post('/akun/add', [AdminController::class, 'storeAccount'])->name('akun.add');
    Route::put('/akun/{username}', [AdminController::class, 'updateAccount'])->name('akun.update');
    Route::delete('/akun/{username}', [AdminController::class, 'deleteAccount'])->name('akun.delete');

    Route::get('/buy', [PembelianController::class, 'buy'])->name('buy');
    Route::get('/buy/admin', [PembelianController::class, 'buyadmin'])->name('buy.admin');
    Route::get('/buy/{id}/detail', [PembelianController::class, 'detail'])->name('buy.detail');
    Route::delete('/buy/{pembelian}', [PembelianController::class, 'destroy'])->name('buy.destroy');

    Route::get('/pembelian/lihat/{tanggal}', [PembelianController::class, 'lihatTanggal'])->name('pembelian.lihat.tanggal');
    Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::delete('pembelian/{pembelian}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
    Route::resource('pembelian', PembelianController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/pembelian/unit/{unit}/tanggal/{tanggal}', [PembelianController::class, 'lihatPerUnit'])->name('pembelian.lihat.perunit');
    Route::post('/pembelian/approve-perunit/{unit}', [PembelianController::class, 'approvePerUnit'])
        ->name('pembelian.approvePerUnit');
    Route::put('/pembelian/{id}/update-harga', [PembelianController::class, 'updateHarga'])->name('pembelian.updateHarga');

    // --- Input Biaya ---
    Route::get('/kalkulator/input-biaya', [BiayaController::class, 'create'])
        ->name('input.biaya');
    Route::post('/kalkulator/input-biaya', [BiayaController::class, 'store'])
        ->name('input.biaya.store');
        
    // --- Input Kalkulator Harga ---
    Route::get('/kalkulator/harga', [KalkulatorController::class, 'index'])
        ->name('input.kalkulator');
    Route::post('/kalkulator/harga/hitung', [KalkulatorController::class, 'hitung'])
        ->name('input.kalkulator.hitung');

    // --- Approval ---
    Route::get('/kalkulator/approval', [ApprovalController::class, 'index'])
        ->name('approval');
    Route::post('/kalkulator/approval/proses', [ApprovalController::class, 'proses'])
        ->name('approval.proses');


    // ============================================================
    //                    REKAP LAPORAN
    // ============================================================
    Route::get('/rekap-laporan', [LaporanController::class, 'index'])
        ->name('rekap.laporan');
});