<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('book')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store($bookId)
    {
        $user = Auth::user();

        // Cek apakah sudah difavoritkan
        if ($user->favorites()->where('book_id', $bookId)->exists()) {
            flash()->error('Buku sudah ada di favorit!');
            return redirect()->back(); // Redirect ke halaman sebelumnya
        }

        Favorite::create([
            'user_id' => $user->id,
            'book_id' => $bookId,
        ]);

        flash()->success('Buku berhasil ditambahkan ke favorit!');
        return redirect()->back(); // Redirect ke halaman sebelumnya
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('book_id', $id)->first();
        if ($favorite) {
            $favorite->delete();
            flash()->success('Buku dihapus dari favorit!');
            return redirect()->back(); // Redirect ke halaman sebelumnya
        }

        flash()->error('Buku tidak ditemukan!');
        return redirect()->back(); // Redirect ke halaman sebelumnya
    }
}
