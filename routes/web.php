<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PinjamBukuController;
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
Route::get('/katalog-buku', [BookController::class, 'index'])->name('katalogBuku');
Route::get('/books/detail/{id}', [BookController::class, 'getBookDetail'])->name('books.detail');
Route::get('/katalog', [BookController::class, 'index'])->name('books.katalogBuku');

// View detail peminjaman
Route::get('/peminjaman/{id}', [BookController::class, 'showPeminjaman'])->name('peminjaman');


Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{bookId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{bookId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});


// Grup route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [PinjamBukuController::class, 'store'])->name('peminjaman.store');
    Route::get('/buku-favorit', [PinjamBukuController::class, 'bukuFavorit'])->name('bukuFavorit');

    Route::get('/riwayat', [RiwayatController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
});

// Donation routes
Route::post('/donate/process', [DonationController::class, 'process'])->name('donate.process')->middleware('auth');


Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');
