<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm()
    {
        return view('login');
    }

    // Menampilkan Daftar Peminjaman Aktif
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->with('book') // Pastikan relasi dengan model Book ada
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // Menampilkan Detail Peminjaman Buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->first();

        return view('peminjaman.show', compact('book', 'peminjaman'));
    }
}
