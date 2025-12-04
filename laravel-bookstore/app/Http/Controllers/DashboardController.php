<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrowing;
use App\Models\BookCategory;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_categories' => BookCategory::count(),
            'total_users' => User::where('role', 'member')->count(),
            'active_borrowings' => BookBorrowing::where('status', 'issued')->count(),
            'books_out_of_stock' => Book::where('stock', 0)->count(),
            'overdue_books' => BookBorrowing::where('status', 'issued')
                ->where('due_date', '<', now())->count(),
        ];

        $recentBorrowings = BookBorrowing::with(['book', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $lowStockBooks = Book::where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->get();

        return view('dashboard', compact('stats', 'recentBorrowings', 'lowStockBooks'));
    }
}
