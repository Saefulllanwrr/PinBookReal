<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm()
    {
        return view('login');
    }

    // Menampilkan Daftar Peminjaman Aktif
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->with('book') // Pastikan relasi dengan model Book ada
            ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    // Menampilkan Detail Peminjaman Buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->first();

        return view('peminjaman.show', compact('book', 'peminjaman'));
    }

    // Proses Peminjaman Buku

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
        ]);

        // Cek ketersediaan buku
        $book = Book::findOrFail($request->buku_id);

        // Cek stok dan status buku
        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'Buku tidak tersedia.');
        }

        // Cek apakah user sudah meminjam buku yang sama
        $peminjamanAktif = Peminjaman::where('buku_id', $book->id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->exists();

        if ($peminjamanAktif) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        // Gunakan DB Transaction untuk memastikan data konsisten
        DB::beginTransaction();
        try {
            // Simpan data peminjaman
            Peminjaman::create([
                'user_id' => Auth::id(),
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => now(),
                'status' => 'dipinjam',
            ]);

            // Update stok dan status buku
            $book->stok--;
            if ($book->stok === 0) {
                $book->status = 'borrowed';
            }
            $book->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat meminjam buku.');
        }

        return back()->with(
            'success',
            'Buku berhasil dipinjam.'
        );
    }

    // Proses Pengembalian Buku
    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Cek apakah user yang meminjam
        if ($peminjaman->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak mengembalikan buku ini.');
        }

        DB::beginTransaction();
        try {
            // Update status peminjaman
            $peminjaman->update([
                'tanggal_kembali' => now(),
                'status' => 'dikembalikan',
            ]);

            // Update stok dan status buku
            $book = Book::findOrFail($peminjaman->buku_id);
            $book->stok++;
            $book->status = 'available';
            $book->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengembalikan buku.');
        }

        return back()->with(
            'success',
            'Buku berhasil dikembalikan.'
        );
    }


    // Menampilkan Riwayat Peminjaman
    public function riwayat()
    {
        $user = Auth::user();



        // Ambil semua peminjaman, termasuk yang sudah dikembalikan
        $riwayat = Peminjaman::where('user_id', Auth::id())
            ->with('book')
            ->latest()
            ->get();

        return view('riwayat.index', compact('riwayat'));
    }
}
