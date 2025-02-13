<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->with('book') // Pastikan relasi dengan model Book ada
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $id) // Sesuaikan dengan nama kolom yang benar
            ->where('status', 'dipinjam')
            ->first();

        return view('peminjaman', compact('book', 'peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id', // Ubah 'buku' menjadi 'books'
        ]);

        // Cek apakah buku tersedia
        $book = Book::findOrFail($request->buku_id);
        $peminjamanAktif = Peminjaman::where('buku_id', $book->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($peminjamanAktif) {
            return back()->with('error', 'Buku ini sedang dipinjam.');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam',
        ]);

        return back()->with('success', 'Buku berhasil dipinjam.');
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan',
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function riwayat()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Anda harus login untuk melihat riwayat peminjaman.');
        }

        // Ambil semua peminjaman, termasuk yang sudah dikembalikan
        $riwayat = Peminjaman::where('user_id', Auth::id())->with('book')->latest()->get();


        return view('riwayat.index', compact('riwayat'));
    }
}
