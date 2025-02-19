<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function generateAvatar($name)
    {
        // Generate avatar
        $avatar = Avatar::create($name)->toBase64();

        // Simpan avatar ke storage
        $avatarPath = 'avatars/' . uniqid() . '.png';
        Storage::disk('public')->put($avatarPath, base64_decode($avatar));

        // Simpan path ke database (contoh untuk user yang sedang login)
        $user = Auth::user();
        $user->avatar_path = $avatarPath;


        // Return sebagai response gambar
        return response($avatar)->header('Content-Type', 'image/png');
    }

    public function showProfile()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Kirim data avatarPath ke view
        return view('nama_view', ['avatarPath' => $user->avatar_path]);
    }
}
