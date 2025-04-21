<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'books';

    protected $fillable = [
        'isbn',
        'judul',
        'penerbit',
        'penulis',
        'deskripsi',
        'diterbitkan',
        'cover',
        'stok',
        'status',
        'kategori_id',
        'borrow_count',
    ];

    public function increaseBorrowCount()
    {
        $this->increment('borrow_count');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function loans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id'); // Tetap gunakan 'buku_id'
    }

    public function favoritedBy()
    {
        return $this->hasMany(Favorite::class);
    }
}
