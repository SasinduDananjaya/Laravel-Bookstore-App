<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BookCategory::withCount('books')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_cate,name',
        ]);

        BookCategory::create($request->only('name'));

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_cate,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCategory $category)
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated books!');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
