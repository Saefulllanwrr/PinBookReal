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
            return back()->with('error', 'Buku sudah ada di favorit!');
        }

        Favorite::create([
            'user_id' => $user->id,
            'book_id' => $bookId,
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke favorit!');
    }

    public function destroy($id)
    {
        $favorite = Favorite::where('user_id', Auth::id())->where('book_id', $id)->first();
        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Buku dihapus dari favorit!');
        }

        return back()->with('error', 'Buku tidak ditemukan!');
    }
}
