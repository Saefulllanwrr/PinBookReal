<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class PinjamBukuController extends Controller
{
    /**
     * Menyimpan data peminjaman buku.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $userId = Auth::id();
        $bukuId = $request->buku_id;

        // Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $existingPeminjaman = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($existingPeminjaman) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan peminjaman atau masih meminjam buku ini.');
        }

        $book = Book::findOrFail($bukuId);

        if ($book->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku habis, tidak dapat meminjam.');
        }

        // Transaksi untuk menjaga konsistensi data
        DB::transaction(function () use ($book, $request, $userId) {
            Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'menunggu',
            ]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Permintaan peminjaman berhasil diajukan, menunggu persetujuan admin.');
    }
}
