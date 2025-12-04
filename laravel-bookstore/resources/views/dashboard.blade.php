@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
{{-- Dashboard page header --}}
<div class="p-2 mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Dashboard</h1>
</div>

{{-- stats cards --}}
<div class="p-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    {{-- Total books --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">📚</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Books</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['total_books'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- categories --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">📂</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Categories</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- members --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">👥</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Members</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- active barrowings --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">📖</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Active Borrowings</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['active_borrowings'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- out of stocks --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">⚠️</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Out of Stock</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['books_out_of_stock'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Overdue Books --}}
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-4 sm:p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-orange-500 rounded-md p-2.5 sm:p-3">
                    <span class="text-white text-xl sm:text-2xl">⏰</span>
                </div>
                <div class="ml-4 sm:ml-5 min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Overdue Books</p>
                    <p class="text-xl sm:text-2xl font-semibold text-gray-900">{{ $stats['overdue_books'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent borrowings  --}}
<div class="m-2 bg-white shadow rounded-lg mb-6 sm:mb-8">
    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
        <h2 class="text-base sm:text-lg font-semibold text-gray-900">Recent Borrowings</h2>
    </div>
    
    {{-- Desktop borrowings table --}}
    <div class="hidden sm:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Issue Date</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentBorrowings as $borrowing)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-900">
                        <div class="max-w-[150px] sm:max-w-[200px] truncate">{{ $borrowing->book->title }}</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">
                        <div class="max-w-[100px] sm:max-w-[150px] truncate">{{ $borrowing->user->name }}</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                        {{ $borrowing->issue_date->format('M d, Y') }}
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $borrowing->status === 'issued' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 sm:px-6 py-4 text-center text-gray-500">No recent borrowings</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile view for borrowings --}}
    <div class="sm:hidden divide-y divide-gray-200">
        @forelse($recentBorrowings as $borrowing)
        <div class="p-4 space-y-2">
            <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $borrowing->book->title }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $borrowing->user->name }}</p>
                </div>
                <span class="ml-2 flex-shrink-0 px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $borrowing->status === 'issued' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($borrowing->status) }}
                </span>
            </div>
            <p class="text-xs text-gray-400">
                📅 {{ $borrowing->issue_date->format('M d, Y') }}
            </p>
        </div>
        @empty
        <div class="p-4 text-center text-gray-500 text-sm">
            No recent borrowings
        </div>
        @endforelse
    </div>
</div>

{{-- stocks alerts --}}
@if($lowStockBooks->count() > 0)
<div class="m-2 grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
    @php
        $outOfStockBooks = $lowStockBooks->where('stock', 0);
        $lowStockOnly = $lowStockBooks->where('stock', '>', 0);
    @endphp

    {{-- Out of stock alert --}}
    @if($outOfStockBooks->count() > 0)
    <div class="bg-red-50 border-l-4 border-red-400 p-3 sm:p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="text-red-400 text-lg sm:text-xl">🚫</span>
            </div>
            <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                <h3 class="text-xs sm:text-sm font-medium text-red-800">Out of Stock</h3>
                <div class="mt-2 text-xs sm:text-sm text-red-700">
                    <ul class="space-y-1.5 sm:space-y-2">
                        @foreach($outOfStockBooks as $book)
                        <li class="flex items-center justify-between gap-2">
                            <span class="truncate flex-1">{{ $book->title }}</span>
                            <span class="flex-shrink-0 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-red-200 text-red-800 rounded text-xs font-semibold">
                                0 left
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Low stock alert  --}}
    @if($lowStockOnly->count() > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 sm:p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="text-yellow-400 text-lg sm:text-xl">⚠️</span>
            </div>
            <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                <h3 class="text-xs sm:text-sm font-medium text-yellow-800">Low Stock Alert</h3>
                <div class="mt-2 text-xs sm:text-sm text-yellow-700">
                    <ul class="space-y-1.5 sm:space-y-2">
                        @foreach($lowStockOnly as $book)
                        <li class="flex items-center justify-between gap-2">
                            <span class="truncate flex-1">{{ $book->title }}</span>
                            <span class="flex-shrink-0 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-yellow-200 text-yellow-800 rounded text-xs font-semibold">
                                {{ $book->stock }} left
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif
@endsection