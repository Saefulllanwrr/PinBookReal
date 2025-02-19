<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Menampilkan daftar buku dengan fitur pencarian dan filter kategori
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $booksQuery = Book::with('kategori');

        if ($request->filled('kategori')) {
            $booksQuery->where('kategori_id', $request->kategori);
        }

        if ($request->filled('query')) {
            $query = $request->query('query');
            $booksQuery->where(function ($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                    ->orWhere('penulis', 'like', '%' . $query . '%')
                    ->orWhere('penerbit', 'like', '%' . $query . '%');
            });
        }

        $books = $booksQuery->paginate(8);
        // Ambil buku yang paling sering dipinjam (favorit)
        $favoriteBooks = Book::withCount('loans')
            ->whereHas('loans') // Hanya buku yang memiliki peminjaman
            ->orderByDesc('loans_count')
            ->take(5)
            ->get();


        return view('books.katalogBuku', compact('kategori', 'books', 'favoriteBooks'));
    }

    // Menampilkan detail buku dalam format JSON
    public function getBookDetail($id)
    {
        $book = Book::with('kategori')
            ->select('id', 'judul', 'penulis', 'penerbit', 'deskripsi', 'cover', 'kategori_id')
            ->findOrFail($id);

        return response()->json([
            'judul' => $book->judul,
            'penulis' => $book->penulis,
            'penerbit' => $book->penerbit,
            'nama_kategori' => $book->kategori->nama_kategori ?? 'Tidak ada kategori',
            'deskripsi' => $book->deskripsi,
            'cover' => asset('storage/' . $book->cover)
        ]);
    }

    // Menampilkan halaman peminjaman buku
    public function showPeminjaman($book_id)
    {
        $book = Book::findOrFail($book_id);
        return view('books.peminjaman', compact('book'));
    }

    // Menampilkan halaman home dengan buku terbaru
    public function showHome()
    {
        $books = Book::latest()->limit(4)->get();
        return view('home', compact('books'));
    }
}
