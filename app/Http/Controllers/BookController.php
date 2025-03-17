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

        // Filter berdasarkan kategori
        $booksQuery->when($request->filled('kategori'), function ($query) use ($request) {
            $query->where('kategori_id', $request->input('kategori'));
        });

        // Pencarian berdasarkan judul, penulis, atau penerbit
        $booksQuery->when($request->filled('query'), function ($query) use ($request) {
            $searchQuery = $request->input('query'); // Ambil input query dengan aman
            $query->where(function ($q) use ($searchQuery) {
                $q->where('judul', 'like', '%' . $searchQuery . '%')
                    ->orWhere('penulis', 'like', '%' . $searchQuery . '%')
                    ->orWhere('penerbit', 'like', '%' . $searchQuery . '%');
            });
        });

        $books = $booksQuery->paginate(8);

        // Ambil buku yang paling sering dipinjam (favorit)
        $favoriteBooks = Book::where('borrow_count', '>', 0)
            ->orderByDesc('borrow_count')
            ->take(5)
            ->get();

        return view('books.katalogBuku', compact('kategori', 'books', 'favoriteBooks'));
    }


    // Menampilkan detail buku dalam format JSON
    public function getBookDetail($id)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Buku tidak ditemukan'
            ], 404);
        }
    }

    // Menampilkan halaman peminjaman buku
    public function showPeminjaman($book_id)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $book = Book::findOrFail($book_id);
        return view('books.peminjaman', compact('book'));
    }

    // Menampilkan halaman home dengan buku terbaru
    public function showHome()
    {
        $books = Book::latest('created_at')->limit(4)->get();
        return view('home', compact('books'));
    }
}
