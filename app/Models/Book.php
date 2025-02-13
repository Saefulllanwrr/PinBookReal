<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    use HasFactory;

    protected $table = 'books';

    // Menentukan field yang bisa diisi massal
    protected $fillable = ['judul', 'penerbit', 'penulis', 'diterbitkan', 'cover'];
}
