<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCategory;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('book_category_id', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'updated_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $books = $query->paginate(10)->withQueryString();
        $categories = BookCategory::all();

        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $categories = BookCategory::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        Book::create($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('category', 'borrowings.user');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = BookCategory::all();
        return view('books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
