<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Siswa\FavoriteController;
use App\Http\Controllers\Siswa\SiswaKatalogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════
// LANDING PAGE
// ═══════════════════════════════════════
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'penjaga' => redirect()->route('penjaga.dashboard'),
            'siswa'   => redirect()->route('siswa.dashboard'),
            default   => view('landing'),
        };
    }
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

        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
        Route::post('/favorite/toggle/{bookId}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
        Route::delete('/favorite/{bookId}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

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
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Kategori CRUD
        Route::resource('/kategori', CategoryController::class)->except(['create', 'show', 'edit']);

        // Data Buku
        Route::resource('/buku', BookController::class)->except(['create', 'show', 'edit'])->parameters(['buku' => 'buku']);

        // Peminjaman
        Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/{peminjaman}', [BorrowingController::class, 'show'])->name('peminjaman.show');

        // Denda
        Route::get('/denda', [FineController::class, 'index'])->name('denda.index');
        Route::get('/denda/{denda}', [FineController::class, 'show'])->name('denda.show');

        // Data Pengguna
        Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
        Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
        Route::put('/pengguna/{pengguna}', [UserController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{pengguna}', [UserController::class, 'destroy'])->name('pengguna.destroy');

        // Hak Akses
        Route::get('/hak-akses', [UserController::class, 'hakakses'])->name('hakakses');
        Route::post('/hak-akses/{pengguna}', [UserController::class, 'hakaksesUpdate'])->name('hakakses.update');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

        // Placeholder untuk halaman yang belum diimplementasi
        Route::get('/page/{page}', function ($page) {
            return view('admin.placeholder', compact('page'));
        })->name('placeholder');
    });

// ═══════════════════════════════════════
// REQUIRE AUTH ROUTES
// ═══════════════════════════════════════
require __DIR__.'/auth.php';