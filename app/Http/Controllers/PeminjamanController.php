<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman aktif
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->with('book')
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // Menampilkan detail peminjaman buku
    public function show($id)
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->with('book')
            ->firstOrFail();

        return view('peminjaman.show', compact('peminjaman'));
    }

    // Membatalkan peminjaman jika status masih "menunggu"
    public function cancel($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        // Kembalikan stok buku
        $book = Book::find($peminjaman->book_id);
        if ($book) {
            $book->increment('stok');
        }

        // Hapus data peminjaman
        $peminjaman->delete();
        flash()->success('Peminjaman berhasil dibatalkan');
        return redirect()->route('peminjaman.index');
    }
}
