<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\PeminjamanController;

// Halaman Home (hanya bisa diakses oleh user dengan role 'user')
Route::post('/midtrans/notification', [notificationController::class, 'handleNotification']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', [BookController::class, 'showHome'])->name('home');

// Pencarian Buku
Route::get('/search', [BookController::class, 'searchForUser'])->name('search');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('show.register');
Route::post('/register/submit', [AuthController::class, 'submitRegister'])->name('register.submit');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Resource Routes for Books
Route::resource('books', BookController::class);

// Resource Routes for Kategori (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
});

// View katalog
Route::get('/katalog-buku', [BookController::class, 'searchForUser'])->name('katalogBuku');

// View detail peminjaman
Route::get('/peminjaman/{id}', [BookController::class, 'showPeminjaman'])->name('peminjaman');

// Grup route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/pinjam', [PeminjamanController::class, 'store'])->name('pinjam.store');
    Route::post('/buku-dikembalikan/{id}', [PeminjamanController::class, 'kembali'])->name('buku.kembalikan');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat.index');
});

// Donation routes
Route::post('/donate/process', [DonationController::class, 'process'])->name('donate.process');
