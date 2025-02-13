<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';  // Menetapkan guard khusus untuk admin

    // Pastikan model Admin merujuk ke tabel yang benar
    protected $table = 'users';  // Jika menggunakan tabel yang sama dengan user

    // Jika kolom role digunakan untuk membedakan user dan admin
    protected $casts = [
        'role' => 'string',
    ];
}
