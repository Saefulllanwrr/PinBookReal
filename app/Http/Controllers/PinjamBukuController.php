<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $existingPeminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->where('status', 'Dipinjam')
            ->first();

        if ($existingPeminjaman) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya.');
        }

        $buku = Book::find($request->buku_id);
        if ($buku->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku habis, tidak dapat meminjam.');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dipinjam!');
    }
}
