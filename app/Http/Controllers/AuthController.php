<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{


    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Menangani form login
    public function submitLogin(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah pengguna ada di database
        $user = User::where('username', $credentials['username'])
            ->orWhere('email', $credentials['username'])
            ->first();

        if (!$user) {
            flash()->error('Username atau Email tidak ditemukan');
            return back();
        }

        // Cek apakah akun diblokir
        if ($user->is_blocked) {
            flash()->error('Akun Anda telah diblokir. Silakan hubungi admin.');
            return back();
        }

        // Cek apakah "Remember Me" dicentang
        $remember = $request->has('remember');

        // Coba login dengan username atau email
        if (
            Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember) ||
            Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $remember)
        ) {
            $request->session()->regenerate();
            flash()->success('Login Berhasil!');
            return redirect()->route('home');
        }
        flash()->error('Username atau Password salah!');
        return back();
    }


    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie "Remember Me"
        $cookie = Cookie::forget(Auth::getRecallerName());
        flash()->success('Logout Berhasil!');
        return redirect()->route('login')->withCookie($cookie);
    }
}
