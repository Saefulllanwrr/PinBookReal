<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class StrukController extends Controller
{
    public function strukPeminjaman($id)
    {
        // Ambil data peminjaman berdasarkan ID
        $peminjaman = Peminjaman::with(['user', 'book'])->findOrFail($id);

        // Pastikan relasi user dan book tersedia
        if (!$peminjaman->user || !$peminjaman->book) {
            abort(404, 'Data peminjaman tidak lengkap.');
        }

        // Load view dan kirim data peminjaman
        $pdf = Pdf::loadView('struk.index', ['peminjaman' => $peminjaman]);

        // Stream PDF ke browser
        return $pdf->stream('struk_peminjaman.pdf');
    }
}
