<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Peminjaman extends Model
{
    use HasFactory, Notifiable;

    protected $table = "peminjaman";

    protected $fillable = [
        'user_id',
        'buku_id', // Gunakan book_id agar lebih konsisten
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'buku_id');
    }
}
