<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

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

        // Coba username dengan username atau email
        if (
            Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']]) ||
            Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])
        ) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'login Berhasil!');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil Logout!');
    }
}
