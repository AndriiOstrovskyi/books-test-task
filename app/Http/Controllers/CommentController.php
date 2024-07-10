<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $book = Book::findOrFail($id);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->book_id = $book->id;
        $comment->content = $request->content;
        $comment->save();

        return back()->with('success', 'Ваш коментар успішно збережено.');
    }
}
