<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $fillable = ['user_id', 'buku_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function book()
    {
        return $this->belongsTo(Book::class, 'buku_id');
    }
}
