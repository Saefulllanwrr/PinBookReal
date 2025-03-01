<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;

class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role']; // Tambahkan role

    protected $attributes = [
        'role' => 'admin', // Default role admin
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->role === 'admin'; // Hanya admin yang bisa akses Filament
    }

    public function notifications() // ✅ Tambahkan ini
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }
}
