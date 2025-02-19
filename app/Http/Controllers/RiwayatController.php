<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{

    // Menampilkan Riwayat Peminjaman
    public function riwayat()
    {
        $riwayat = Peminjaman::where('user_id', Auth::id())
            ->with('book')
            ->latest()
            ->get();

        return view('riwayat.index', compact('riwayat'));
    }
}
