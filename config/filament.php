<?php

use Filament\Pages\Auth\Login;

return [

    'broadcasting' => [
        // Konfigurasi broadcasting untuk Laravel Echo
        // Uncomment jika ingin menggunakan Pusher
    ],

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'assets_path' => null,

    'cache_path' => base_path('bootstrap/cache/filament'),

    'livewire_loading_delay' => 'default',

    'auth' => [
        'guard' => 'admin', // Pakai guard admin
        'pages' => [
            'login' => Login::class,
            'register' => \Filament\Pages\Auth\Register::class, // Tambahkan register di dalam 'pages'
        ],
    ],

];
