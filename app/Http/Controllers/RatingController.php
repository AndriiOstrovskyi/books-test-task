<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        $book = Book::findOrFail($id);

        if ($book->ratings()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Ви вже залишали рейтинг для цієї книги.');
        }

        $rating = new Rating();
        $rating->user_id = Auth::id();
        $rating->book_id = $book->id;
        $rating->rating = $request->rating;
        $rating->save();

        return back()->with('success', 'Ваш рейтинг успішно збережено.');
    }
}
