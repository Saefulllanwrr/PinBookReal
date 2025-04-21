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
        // Validasi input
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => [
                'required',
                'date',
                'after:tanggal_pinjam',
                function ($attribute, $value, $fail) use ($request) {
                    $tanggalPinjam = new \DateTime($request->tanggal_pinjam);
                    $tanggalKembali = new \DateTime($value);
                    $selisihHari = $tanggalPinjam->diff($tanggalKembali)->days;

                    if ($selisihHari > 5) {
                        flash()->error('Maksimal peminjaman adalah 5 hari.');
                        return $fail('Maksimal peminjaman adalah 5 hari.');
                    }
                },
            ],
        ]);

        $userId = Auth::id();
        $bukuId = $request->buku_id;

        // Cek apakah user sudah meminjam buku yang sama
        $existingPeminjaman = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($existingPeminjaman) {
            flash()->error('Anda sudah mengajukan peminjaman atau masih meminjam buku ini.');
            return redirect()->back();
        }

        // Cek stok buku
        $book = Book::findOrFail($bukuId);
        if ($book->stok < 1) {
            flash()->error('Stok buku habis, tidak dapat meminjam.');
            return redirect()->back();
        }

        try {
            DB::transaction(function () use ($book, $request, $userId) {
                // Simpan data peminjaman
                $peminjaman = Peminjaman::create([
                    'user_id' => $userId,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'menunggu',
                ]);

                // Update stok dan borrow_count
                $book->decrement('stok');
                $book->increment('borrow_count'); // Tambahkan ini untuk menambah jumlah peminjaman

                // Update status buku jika stok habis
                if ($book->stok <= 0) {
                    $book->update(['status' => 'borrowed']);
                }
            });

            flash()->success('Permintaan peminjaman berhasil diajukan, menunggu persetujuan admin.');
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {


            flash()->error('Terjadi kesalahan saat memproses peminjaman.');
            return redirect()->back();
        }
    }
}
