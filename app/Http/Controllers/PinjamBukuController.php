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
            'buku_id' => 'required|exists:books,id', // Pastikan buku_id ada di tabel books
            'tanggal_pinjam' => 'required|date|after_or_equal:today', // Tanggal pinjam harus hari ini atau setelahnya
            'tanggal_kembali' => [
                'required',
                'date',
                'after:tanggal_pinjam', // Tanggal kembali harus setelah tanggal pinjam
                function ($attribute, $value, $fail) use ($request) {
                    // Hitung selisih hari antara tanggal kembali dan tanggal pinjam
                    $tanggalPinjam = new \DateTime($request->tanggal_pinjam);
                    $tanggalKembali = new \DateTime($value);
                    $selisihHari = $tanggalPinjam->diff($tanggalKembali)->days;

                    // Jika selisih hari lebih dari 5, tampilkan pesan error
                    if ($selisihHari > 5) {
                        flash()->error('Maksimal peminjaman adalah 5 hari.');
                        return $fail('Maksimal peminjaman adalah 5 hari.');
                    }
                },
            ],
        ]);

        $userId = Auth::id(); // Ambil ID user yang sedang login
        $bukuId = $request->buku_id; // Ambil ID buku dari request

        // Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $existingPeminjaman = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $bukuId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        // Jika sudah meminjam, tampilkan pesan error
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
            // Mulai transaksi database
            DB::transaction(function () use ($book, $request, $userId) {
                // Simpan data peminjaman
                $peminjaman = Peminjaman::create([
                    'user_id' => $userId,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'menunggu', // Status awal peminjaman
                ]);

                // Kurangi stok buku
                $book->decrement('stok');
            });

            // Tampilkan pesan sukses
            flash()->success('Permintaan peminjaman berhasil diajukan, menunggu persetujuan admin.');
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            // Tangani kesalahan
            flash()->error('Terjadi kesalahan saat memproses peminjaman.');
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses peminjaman.');
        }
    }
}
