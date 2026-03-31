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
use App\Http\Controllers\Siswa\SiswaTransaksiController;
use App\Http\Controllers\Siswa\SiswaKartuController;
use App\Http\Controllers\Siswa\SiswaProfilController;
use App\Http\Controllers\Siswa\SiswaPengajuanController;
use App\Http\Controllers\Penjaga\PenjagaInboxController;
use App\Http\Controllers\Penjaga\PenjagaPeminjamanController;
use App\Http\Controllers\Penjaga\PenjagaPengembalianController;
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
            'siswa'   => redirect()->route('siswa.halaman'),
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
            $userId = Auth::id();
            
            $dipinjam = \App\Models\Borrowing::where('user_id', $userId)
                ->where('status', 'dipinjam')
                ->count();
                
            $belumKembali = \App\Models\Borrowing::where('user_id', $userId)
                ->where('status', 'dipinjam')
                ->whereNotNull('deadline')
                ->whereDate('deadline', '<', now())
                ->count();
            
            // Hitung Denda (Unpaid DB + Estimasi realtime yang belum masuk DB)
            $dendaDariDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
                ->where('payment_status', 'unpaid')->sum('amount'));
                
            $lateLoansEstimasi = \App\Models\Borrowing::where('user_id', $userId)
                ->where('status', 'dipinjam')
                ->whereNotNull('deadline')
                ->whereDate('deadline', '<', now())
                ->doesntHave('fine')
                ->get();
                
            $dendaEstimasi = $lateLoansEstimasi->sum(function ($loan) {
                return now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($loan->deadline)->startOfDay()) * 2000;
            });
            
            $dendaAktif = $dendaDariDB + $dendaEstimasi;

            return view('siswa.dashboard', compact('dipinjam', 'belumKembali', 'dendaAktif'));
        })->name('dashboard');

        Route::get('/halaman', [\App\Http\Controllers\Siswa\SiswaHalamanController::class, 'index'])->name('halaman');

        Route::get('/katalog', [SiswaKatalogController::class, 'index'])->name('katalog');
        Route::get('/katalog/{id}', [SiswaKatalogController::class, 'show'])->name('katalog.show');
        Route::post('/pinjam/{id}', [SiswaKatalogController::class, 'pinjam'])->name('pinjam');

        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite');
        Route::post('/favorite/toggle/{bookId}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
        Route::delete('/favorite/{bookId}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

        Route::get('/transaksi', [SiswaTransaksiController::class, 'index'])->name('transaksi');
        Route::get('/riwayat', [SiswaTransaksiController::class, 'riwayat'])->name('riwayat');
        Route::post('/denda/bayar', [SiswaTransaksiController::class, 'bayarDenda'])->name('denda.bayar');

        // Kartu Anggota (legacy route, kept for backward compat)
        Route::get('/kartu-anggota', [SiswaKartuController::class, 'index'])->name('kartu');

        // Profil Siswa
        Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil');
        Route::patch('/profil', [SiswaProfilController::class, 'update'])->name('profil.update');
        Route::patch('/profil/password', [SiswaProfilController::class, 'updatePassword'])->name('profil.password');
        Route::post('/profil/avatar', [SiswaProfilController::class, 'updateAvatar'])->name('profil.avatar');
        
        // Pengajuan
        Route::get('/pengajuan', [SiswaPengajuanController::class, 'index'])->name('pengajuan');
        Route::get('/pengajuan/create', [SiswaPengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan', [SiswaPengajuanController::class, 'store'])->name('pengajuan.store')->middleware('throttle:10,1');
        Route::post('/pengajuan/pesan', [SiswaPengajuanController::class, 'sendMessage'])->name('pengajuan.pesan')->middleware('throttle:10,1');

        // Ulasan Buku
        Route::post('/katalog/{id}/review', [SiswaKatalogController::class, 'review'])->name('katalog.review');

        // Batal Booking
        Route::delete('/booking/{id}/batal', [SiswaKatalogController::class, 'batalBooking'])->name('booking.batal');
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

        // Peminjaman
        Route::get('/peminjaman', [PenjagaPeminjamanController::class, 'index'])->name('peminjaman');
        Route::post('/peminjaman/cari', [PenjagaPeminjamanController::class, 'cariBooking'])->name('peminjaman.cari');
        Route::post('/peminjaman/konfirmasi', [PenjagaPeminjamanController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');

        // Pengembalian
        Route::get('/pengembalian', [PenjagaPengembalianController::class, 'index'])->name('pengembalian');
        Route::post('/pengembalian/kembalikan/{id}', [PenjagaPengembalianController::class, 'kembalikan'])->name('pengembalian.kembalikan');

        // Riwayat Transaksi
        Route::get('/riwayat', [PenjagaPengembalianController::class, 'riwayat'])->name('riwayat');

        // Inbox
        Route::get('/inbox', [PenjagaInboxController::class, 'index'])->name('inbox');
        Route::post('/inbox/pengajuan/{id}/status', [PenjagaInboxController::class, 'updateStatusPengajuan'])->name('inbox.updateStatusPengajuan');
        Route::get('/inbox/{id}', [PenjagaInboxController::class, 'show'])->name('inbox.show');
        Route::delete('/inbox/{id}', [PenjagaInboxController::class, 'destroy'])->name('inbox.destroy');
    });

// ADMIN ROUTE
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Data Pengguna
        Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna.index');
        Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna.store');
        Route::put('/pengguna/{pengguna}', [UserController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{pengguna}', [UserController::class, 'destroy'])->name('pengguna.destroy');

        // Hak Akses
        Route::get('/hak-akses', [UserController::class, 'hakakses'])->name('hakakses');
        Route::post('/hak-akses/{pengguna}', [UserController::class, 'hakaksesUpdate'])->name('hakakses.update');

        // Verifikasi Anggota
        Route::get('/verifikasi', [UserController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/verifikasi/{pengguna}', [UserController::class, 'verifikasiUpdate'])->name('verifikasi.update');



        // Placeholder untuk halaman yang belum diimplementasi
        Route::get('/page/{page}', function ($page) {
            return view('admin.placeholder', compact('page'));
        })->name('placeholder');
    });

// ADMIN & PENJAGA SHARED ROUTE DENGAN PERMISSION
Route::middleware(['auth', 'role:admin,penjaga'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Kategori CRUD
        Route::resource('/kategori', CategoryController::class)
            ->except(['create', 'show', 'edit'])
            ->middleware(\App\Http\Middleware\PermissionMiddleware::class.':kategori');
            
        // Series Buku CRUD
        Route::resource('/series', \App\Http\Controllers\SeriesController::class)
            ->except(['create', 'show', 'edit'])
            ->middleware(\App\Http\Middleware\PermissionMiddleware::class.':series');

        // Data Buku
        Route::resource('/buku', BookController::class)
            ->except(['show', 'edit'])
            ->parameters(['buku' => 'buku'])
            ->middleware(\App\Http\Middleware\PermissionMiddleware::class.':buku');

        // Peminjaman
        Route::get('/peminjaman', [BorrowingController::class, 'index'])
            ->name('peminjaman.index')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':peminjaman');
        Route::get('/peminjaman/{peminjaman}', [BorrowingController::class, 'show'])
            ->name('peminjaman.show')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':peminjaman');

        // Denda
        Route::get('/denda', [FineController::class, 'index'])
            ->name('denda.index')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':denda');
        Route::get('/denda/{denda}', [FineController::class, 'show'])
            ->name('denda.show')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':denda');
        Route::post('/denda/{denda}/kembalikan', [FineController::class, 'kembalikan'])
            ->name('denda.kembalikan')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':denda');
        Route::post('/denda/{code}/verifikasi', [FineController::class, 'verifikasi'])
            ->name('denda.verifikasi')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':denda');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':laporan');
        Route::get('/laporan/export', [LaporanController::class, 'export'])
            ->name('laporan.export')->middleware(\App\Http\Middleware\PermissionMiddleware::class.':laporan');
    });

// ═══════════════════════════════════════
// REQUIRE AUTH ROUTES
// ═══════════════════════════════════════
require __DIR__.'/auth.php';