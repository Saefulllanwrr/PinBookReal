<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable implements FilamentUser
{
    use HasFactory;


    protected $fillable = ['name', 'email', 'password', 'role', 'remember_token'];

    protected $attributes = [
        'role' => 'admin', // Default role admin
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true;
    }
}
