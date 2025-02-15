<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookTableSeeder extends Seeder
{
    public function run()
    {
        // Data Dummy untuk Random
        $judulBuku = [
            'Belajar Laravel dari Dasar',
            'Mastering PHP',
            'JavaScript untuk Pemula',
            'Framework CSS Terbaik',
            'Panduan VueJS',
            'React Native Expert',
            'Database MySQL',
            'Pemrograman Python',
            'Belajar Golang',
            'Flutter Mudah'
        ];

        $penerbit = ['Gramedia', 'Erlangga', 'Andi Publisher', 'Bentang Pustaka', 'Deepublish'];
        $penulis = ['John Doe', 'Jane Smith', 'Ahmad Fauzi', 'Putri Lestari', 'Michael Anggara'];
        $cover = ['cover1.jpg', 'cover2.jpg', 'cover3.jpg', 'cover4.jpg', 'cover5.jpg'];
        $status = ['available', 'not available'];

        for ($i = 1; $i <= 50; $i++) {
            DB::table('books')->insert([
                'judul' => $judulBuku[array_rand($judulBuku)] . ' - Seri ' . rand(1, 10),
                'penerbit' => $penerbit[array_rand($penerbit)],
                'penulis' => $penulis[array_rand($penulis)],
                'diterbitkan' => Carbon::now()->subYears(rand(1, 10))->format('Y-m-d'),
                'kategori_id' => rand(1, 5), // Sesuaikan dengan ID kategori yang ada di tabel kategori
                'cover' => $cover[array_rand($cover)],
                'deskripsi' => 'Buku ini menjelaskan tentang ' . Str::random(20),
                'status' => $status[array_rand($status)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
