<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Fiksi',
                'deskripsi' => 'Buku dengan cerita imajinatif dan tidak berdasarkan kisah nyata.',
            ],
            [
                'nama_kategori' => 'Non-Fiksi',
                'deskripsi' => 'Buku yang berisi fakta, informasi, atau kisah nyata.',
            ],
            [
                'nama_kategori' => 'Komik',
                'deskripsi' => 'Buku yang berisi cerita bergambar dengan dialog singkat.',
            ],
            [
                'nama_kategori' => 'Ensiklopedia',
                'deskripsi' => 'Buku yang berisi kumpulan informasi tentang berbagai topik.',
            ],
            [
                'nama_kategori' => 'Biografi',
                'deskripsi' => 'Buku yang berisi kisah hidup seseorang.',
            ],
            [
                'nama_kategori' => 'Sejarah',
                'deskripsi' => 'Buku yang berisi informasi tentang kejadian di masa lalu.',
            ],
            [
                'nama_kategori' => 'Sains',
                'deskripsi' => 'Buku yang membahas tentang ilmu pengetahuan dan teknologi.',
            ],
            [
                'nama_kategori' => 'Agama',
                'deskripsi' => 'Buku yang membahas tentang ajaran dan nilai-nilai keagamaan.',
            ],
            [
                'nama_kategori' => 'Novel',
                'deskripsi' => 'Buku yang berisi cerita panjang dengan berbagai karakter dan konflik.',
            ],
            [
                'nama_kategori' => 'Puisi',
                'deskripsi' => 'Buku yang berisi kumpulan puisi atau sajak.',
            ],
        ]);
    }
}
