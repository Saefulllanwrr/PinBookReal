<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Fungsi pencarian buku untuk pengguna
    public function index()
    {
        $kategori = Kategori::all();
        $books = Book::paginate(8);

        return view('katalogBuku', compact('kategori', 'books'));
    }
    public function searchForUser(Request $request)
    {
        $query = $request->input('query');

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Cari buku berdasarkan judul, penulis, atau penerbit
        $books = Book::where('judul', 'like', '%' . $query . '%')
            ->orWhere('penulis', 'like', '%' . $query . '%')
            ->orWhere('penerbit', 'like', '%' . $query . '%')
            ->paginate();

        // Arahkan ke halaman katalog dengan hasil pencarian
        return view('books.katalogBuku', compact('kategori', 'books'));
    }

    public function getBookDetail($id)
    {
        $book = Book::findOrFail($id);

        // Mengembalikan data dalam bentuk JSON
        return response()->json([
            'judul' => $book->judul,
            'penulis' => $book->penulis,
            'penerbit' => $book->penerbit,
            'deskripsi' => $book->deskripsi,
            'cover' => asset('storage/' . $book->cover)
        ]);
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
