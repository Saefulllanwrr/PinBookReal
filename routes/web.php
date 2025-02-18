<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\notificationController;

// Halaman Home (hanya bisa diakses oleh user dengan role 'user')
Route::post('/midtrans/notification', [notificationController::class, 'handleNotification']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::get('/', [BookController::class, 'showHome'])->middleware('web')->name('home');

// Pencarian Buku
Route::get('/search', [BookController::class, 'searchForUser'])->name('search');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Resource Routes for Books
Route::resource('books', BookController::class);

// Resource Routes Untuk Kategori (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
});

// View katalog
Route::get('/katalog-buku', [BookController::class, 'searchForUser'])->name('katalogBuku');
Route::get('/books', [BookController::class, 'index'])->name('books.katalogBuku');
Route::get('/books/detail/{id}', [BookController::class, 'getBookDetail'])->name('books.detail');
Route::get('/katalog', [BookController::class, 'index'])->name('books.katalogBuku');


// View detail peminjaman
Route::get('/peminjaman/{id}', [BookController::class, 'showPeminjaman'])->name('peminjaman');

// Grup route yang memerlukan autentikasi

Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
// Route untuk proses peminjaman buku
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat.index');

Route::get('/akun', [AkunController::class, 'index'])->name('akun.index')->middleware('auth');

// Donation routes
Route::post('/donate/process', [DonationController::class, 'process'])->name('donate.process')->middleware('auth');

Route::get('/kontak', [ContactController::class, 'show'])->name('contact.show');

// Route untuk menangani pengiriman form kontak
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.submit');
