<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy untuk tabel books
        $books = [
            [
                'judul' => 'Belajar Laravel dari Dasar',
                'penerbit' => 'Penerbit A',
                'penulis' => 'John Doe',
                'diterbitkan' => '2023-01-15',
                'cover' => 'laravel.jpg',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Panduan Lengkap React JS',
                'penerbit' => 'Penerbit B',
                'penulis' => 'Jane Smith',
                'diterbitkan' => '2022-11-20',
                'cover' => 'react.jpg',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Menguasai Tailwind CSS',
                'penerbit' => 'Penerbit C',
                'penulis' => 'Alice Johnson',
                'diterbitkan' => '2023-03-10',
                'cover' => 'tailwind.jpg',
                'status' => 'unavailable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Pemrograman Python untuk Pemula',
                'penerbit' => 'Penerbit D',
                'penulis' => 'Bob Brown',
                'diterbitkan' => '2021-09-05',
                'cover' => 'python.jpg',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Desain UI/UX Modern',
                'penerbit' => 'Penerbit E',
                'penulis' => 'Charlie Davis',
                'diterbitkan' => '2023-05-25',
                'cover' => 'uiux.jpg',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel books
        DB::table('books')->insert($books);
    }
}
