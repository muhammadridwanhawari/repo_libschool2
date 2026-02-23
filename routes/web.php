<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\SiswaKatalogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════
// LANDING PAGE
// ═══════════════════════════════════════
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ═══════════════════════════════════════
// PROFILE (HARUS LOGIN)
// ═══════════════════════════════════════
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ═══════════════════════════════════════
// SISWA ROUTE
// ═══════════════════════════════════════
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('siswa.dashboard');
        })->name('dashboard');

        Route::get('/katalog', [SiswaKatalogController::class, 'index'])->name('katalog');
        Route::get('/katalog/{id}', [SiswaKatalogController::class, 'show'])->name('katalog.show');
        Route::post('/pinjam/{id}', [SiswaKatalogController::class, 'pinjam'])->name('pinjam');

        Route::get('/favorite', function () {
            return view('siswa.favorite');
        })->name('favorite');

        Route::get('/transaksi', function () {
            return view('siswa.transaksi');
        })->name('transaksi');
    });

// ═══════════════════════════════════════
// PENJAGA ROUTE
// ═══════════════════════════════════════
Route::middleware(['auth', 'role:penjaga'])
    ->prefix('penjaga')
    ->name('penjaga.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('penjaga.dashboard');
        })->name('dashboard');
    });

// ═══════════════════════════════════════
// ADMIN ROUTE
// ═══════════════════════════════════════
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

// ═══════════════════════════════════════
// REQUIRE AUTH ROUTES
// ═══════════════════════════════════════
require __DIR__.'/auth.php';