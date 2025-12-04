<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\User;
use App\Http\Requests\BorrowingRequest;

class BookBorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = BookBorrowing::with(['book', 'user']);

        //members can only see their own borrowings
        if (auth()->user()->isMember()) {
            $query->where('user_id', auth()->id());
        }

        //filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //admin- filter by user
        if ($request->filled('user_id') && auth()->user()->isAdmin()) {
            $query->where('user_id', $request->user_id);
        }

        $borrowings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $users = User::where('role', 'member')->get();

        return view('borrowings.index', compact('borrowings', 'users'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $users = User::where('role', 'member')->get();

        return view('borrowings.create', compact('books', 'users'));
    }

    public function store(BorrowingRequest $request)
    {
        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return back()->with('error', 'This book is currently out of stock!');
        }

        DB::transaction(function () use ($request, $book) {
            BookBorrowing::create([
                'book_id' => $request->book_id,
                'user_id' => $request->user_id,
                'issue_date' => $request->issue_date,
                'due_date' => $request->due_date,
                'status' => 'issued',
                'notes' => $request->notes,
            ]);

            $book->decrementStock();
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Book issued successfully! Stock updated.');
    }

    public function show(BookBorrowing $borrowing)
    {
        //members can only see their own borrowings
        if (auth()->user()->isMember() && $borrowing->user_id !== auth()->id()) {
            abort(403, 'You can only view your own borrowings.');
        }

        $borrowing->load(['book.category', 'user']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function returnBook(BookBorrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'This book has already been returned!');
        }

        DB::transaction(function () use ($borrowing) {
            $borrowing->update([
                'return_date' => now(),
                'status' => 'returned',
            ]);

            $borrowing->book->incrementStock();
        });

        return redirect()->route('borrowings.index')
            ->with('success', 'Book returned successfully! Stock updated.');
    }

    public function destroy(BookBorrowing $borrowing)
    {
        if ($borrowing->status === 'issued') {
            $borrowing->book->incrementStock();
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')
            ->with('success', 'Borrowing record deleted successfully!');
    }
}
