<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Fungsi pencarian buku untuk pengguna
    public function searchForUser(Request $request)
    {
        $query = $request->input('query');

        // Cari buku berdasarkan judul, penulis, atau penerbit
        $books = Book::where('judul', 'like', '%' . $query . '%')
            ->orWhere('penulis', 'like', '%' . $query . '%')
            ->orWhere('penerbit', 'like', '%' . $query . '%')
            ->get();

        // Arahkan ke halaman katalog dengan hasil pencarian
        return view('books.katalogBuku', compact('books'));
    }

    public function showpeminjaman($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('books.peminjaman', compact('book'));
    }

    public function showHome()
    {
        $books = Book::orderBy('created_at', 'desc')->limit(4)->get();

        return view('home', compact('books'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
