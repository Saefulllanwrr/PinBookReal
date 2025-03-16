<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Notifikasi Midtrans




Route::get('/login', [AuthController::class, 'showLoginForm']);
// Login & Logout
Route::prefix('auth')->group(function () {
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware(['auth:sanctum'])->get('/csrf-token', function (Request $request) {
    return response()->json([
        'csrf_token' => csrf_token()
    ]);
});
