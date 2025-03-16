<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
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

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibatalkan.');
    }

    // Mengembalikan buku & menghitung denda
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali);
        $tanggalSekarang = now();

        $denda = 0;
        $status = 'dikembalikan';

        if ($tanggalSekarang->greaterThan($tanggalKembali)) {
            $hariTerlambat = $tanggalSekarang->diffInDays($tanggalKembali);
            $denda = $hariTerlambat * 1000; // Denda Rp 1000 per hari
            $status = 'terlambat';
        }

        $peminjaman->update([
            'status' => $status,
            'denda' => $denda,
            'tanggal_kembali' => $tanggalSekarang,
        ]);

        // Kembalikan stok buku jika ada
        if ($peminjaman->book) {
            $peminjaman->book->increment('stok');
        }

        return redirect()->route('peminjaman.index')
            ->with('success', "Buku berhasil dikembalikan. Denda: Rp " . number_format($denda, 0, ',', '.'));
    }
}
