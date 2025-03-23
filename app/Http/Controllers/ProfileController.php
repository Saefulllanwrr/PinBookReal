<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $users = Auth::user(); // Ambil data users yang sedang login
        return view('akun.index', compact('users')); // Kirim data users ke view
    }

    // Mengupdate data profil
    public function update(Request $request)
    {
        $users = Auth::user(); // Ambil data users yang sedang login

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $users->id,
            'no_telepon' => 'nullable|string|max:15',
        ]);

        $users->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ]);
        flash()->success('Berhasil edit profile');
        // Redirect kembali dengan pesan sukses
        return redirect()->route('profile.show');
    }
}
