<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        }

        $books = $query->orderBy('created_at', 'desc')->take(10)->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string|max:1000',
            'publication_date' => 'required|date',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publication_date = $request->publication_date;
        $book->description = $request->description;

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $book->cover_image = 'images/' . $imageName;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Книга успішно додана!');
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function getUpdatedList()
    {
        $books = Book::orderBy('created_at', 'desc')->take(5)->get();
        return response()->json($books);
    }
}
