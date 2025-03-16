<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'isbn' => '9781234567890',
                'judul' => 'Belajar Laravel untuk Pemula',
                'penerbit' => 'Gramedia',
                'penulis' => 'Saeful Anwar',
                'deskripsi' => 'Buku ini membahas tentang Laravel secara lengkap untuk pemula.',
                'diterbitkan' => '2024-03-10',
                'cover' => 'cover/laravel-book.jpg',
                'kategori_id' => 1,
                'stok' => 10,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '9789876543210',
                'judul' => 'Fundamental React.js',
                'penerbit' => 'Elex Media',
                'penulis' => 'Budi Santoso',
                'deskripsi' => 'Panduan lengkap untuk memahami React.js dalam pengembangan web modern.',
                'diterbitkan' => '2023-07-15',
                'cover' => 'cover/react-book.jpg',
                'kategori_id' => 2,
                'stok' => 5,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '9781111222333',
                'judul' => 'Mastering PHP',
                'penerbit' => 'Packt Publishing',
                'penulis' => 'John Doe',
                'deskripsi' => 'Buku ini membahas PHP dari dasar hingga tingkat lanjut.',
                'diterbitkan' => '2022-09-20',
                'cover' => 'cover/php-book.jpg',
                'kategori_id' => 1,
                'stok' => 3,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '9784445556667',
                'judul' => 'JavaScript for Beginners',
                'penerbit' => 'O’Reilly Media',
                'penulis' => 'Jane Smith',
                'deskripsi' => 'Belajar JavaScript dari nol hingga mahir.',
                'diterbitkan' => '2021-05-30',
                'cover' => 'cover/javascript-book.jpg',
                'kategori_id' => 3,
                'stok' => 8,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '9789998887776',
                'judul' => 'Database Design Principles',
                'penerbit' => 'McGraw Hill',
                'penulis' => 'Michael Johnson',
                'deskripsi' => 'Buku ini membahas tentang prinsip desain database yang baik.',
                'diterbitkan' => '2020-11-12',
                'cover' => 'cover/database-book.jpg',
                'kategori_id' => 4,
                'stok' => 6,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
