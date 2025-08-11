<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PembelianController;

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

Route::middleware('auth')->group(function () {
    Route::get('/akun', [AdminController::class, 'akun'])->name('admin.akun');
    Route::post('/akun/add', [AdminController::class, 'storeAccount'])->name('akun.add');
    Route::put('/akun/{username}', [AdminController::class, 'updateAccount'])->name('akun.update');
    Route::delete('/akun/{username}', [AdminController::class, 'deleteAccount'])->name('akun.delete');
});

Route::get('/view', [AdminController::class, 'view'])->name('view');
Route::get('/progress', [AdminController::class, 'progress'])->name('progress');

Route::middleware(['auth'])->group(function () {
    Route::get('/buy', [PembelianController::class, 'buy'])->name('buy');

    // Route::get('/pembelian/tambah', [PembelianController::class, 'create'])
    //     ->name('pembelian.create');

    // Route::post('/pembelian/store', [PembelianController::class, 'store'])
    //     ->name('pembelian.store');

    Route::resource('pembelian', PembelianController::class);
    Route::delete('pembelian/{pembelian}', [PembelianController::class, 'destroy'])
        ->name('pembelian.destroy');
});