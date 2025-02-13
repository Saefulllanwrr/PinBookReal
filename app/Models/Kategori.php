<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    use HasFactory;
    protected $table = "kategori";
    protected $fillable = [
        "nama_kategori",
        "deskripsi",
    ];
}
