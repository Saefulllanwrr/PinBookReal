<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, MustVerifyEmail;

    protected $fillable = ['name', 'email', 'password', 'role', 'remember_token'];

    protected $attributes = [
        'role' => 'admin', // Default role admin
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}
