<?php

namespace App\Models;

use App\Models\Peminjaman;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Relasi ke tabel peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }

    /**
     * Menentukan apakah user bisa mengakses panel Filament.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->role === 'admin'; // Hanya admin yang bisa masuk ke Filament
    }

    /**
     * Mengecek apakah user memiliki role tertentu.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile',
        'role',
    ];

    /**
     * Attributes yang harus disembunyikan dalam serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting untuk atribut tertentu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
