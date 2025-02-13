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
    // Menampilkan daftar pengguna untuk admin
    public function manageUser()
    {
        $users = User::all();
        return view('manageUser', compact('users'));
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('register');
    }

    // Menangani form registrasi
    public function submitRegister(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',  // Harus ada huruf besar
                'regex:/[0-9]/',  // Harus ada angka

            ],
            [
                'password.regex' => 'Password harus mengandung minimal satu huruf besar, satu angka, dan satu simbol (@$!%*?&).'
            ],
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        // Simpan gambar dengan nama unik jika ada
        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->storeAs(
                'profiles',
                Str::random(20) . '.' . $request->file('profile')->extension(),
                'public'
            );
        }

        // Membuat user baru
        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'profile' => $profilePath,
        ]);

        // Trigger event Registered
        event(new Registered($user));

        // Auto-login setelah registrasi
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi Berhasil!');
    }

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

        return redirect()->route('login')->with('success', 'Berhasil Logout!');
    }
}
