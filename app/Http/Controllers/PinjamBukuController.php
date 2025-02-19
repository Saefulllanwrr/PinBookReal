<?php

namespace App\Http\Controllers;

use App\Models\Book; // Gunakan model Book
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class PinjamBukuController extends Controller
{
    /**
     * Menyimpan data peminjaman buku.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'buku_id' => 'required|exists:books,id', // Sesuaikan dengan nama tabel books
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        // Cek stok buku
        $buku = Book::find($request->buku_id); // Gunakan model Book
        if ($buku->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku habis, tidak dapat meminjam.');
        }

        // Buat peminjaman
        $peminjaman = new Peminjaman();
        $peminjaman->user_id = Auth::id(); // ID user yang sedang login
        $peminjaman->buku_id = $request->buku_id;
        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam; // Sesuaikan dengan kolom model
        $peminjaman->tanggal_kembali = $request->tanggal_kembali; // Sesuaikan dengan kolom model
        $peminjaman->status = 'Dipinjam'; // Status awal peminjaman
        $peminjaman->save();

        // Kurangi stok buku
        $buku->stok -= 1;
        $buku->save();

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dipinjam.');
    }
}
