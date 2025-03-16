<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Cek apakah user sudah memberi rating sebelumnya
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->first();

        if ($existingRating) {
            $existingRating->update(['rating' => $request->rating]);
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'book_id' => $bookId,
                'rating' => $request->rating,
            ]);
        }

        return redirect()->back()->with('success', 'Rating berhasil diberikan!');
    }

    public function getAverageRating($bookId)
    {
        $average = Rating::where('book_id', $bookId)->avg('rating');
        return response()->json(['average_rating' => $average ?: 0]);
    }
}
