@extends('layouts.app')

@section('title', 'Books')

@section('content')
{{-- Books page --}}
<div class="m-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Books</h1>
    
    {{-- Add book btn for admin only --}}
    @if(auth()->user()->isAdmin())
    <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center text-sm sm:text-base">
        + Add New Book
    </a>
    @endif
</div>

{{-- Book filters --}}
<div class="m-2 bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
    <form method="GET" action="{{ route('books.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search by Title</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Enter title..."
                   class="filter-input w-full rounded-xl p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" class="text-base filter-input w-full rounded-xl p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
            <input type="number" name="min_price" value="{{ request('min_price') }}" step="0.01" min="0"
                   placeholder="Min"
                   class="filter-input w-full rounded-xl p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
            <input type="number" name="max_price" value="{{ request('max_price') }}" step="0.01" min="0"
                   placeholder="Max"
                   class="filter-input w-full rounded-xl p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="flex items-end space-x-2 sm:col-span-2 lg:col-span-1">
            <button id="bookFilterBtn" type="submit" class="flex-1 sm:flex-none bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Filter
            </button>
            <a id="clearBtn" href="{{ route('books.index') }}" class="flex-1 sm:flex-none text-center bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed pointer-events-none">
                Clear
            </a>
        </div>
    </form>
</div>

{{-- Desktop books table --}}
<div class="m-2 hidden md:block bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                
                {{-- Edit, delete actions for admin only --}}
                @if(auth()->user()->isAdmin())
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($books as $book)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                        {{ $book->title }}
                    </a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->author }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $book->category->name }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($book->price, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($book->stock == 0)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                    @elseif($book->stock <= 3)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $book->stock }} left</span>
                    @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ $book->stock }} in stock</span>
                    @endif
                </td>
                {{-- actions for admin only --}}
                @if(auth()->user()->isAdmin())
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('books.edit', $book) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" 
                          class="inline delete-book-form" 
                          data-book-title="{{ $book->title }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="px-6 py-4 text-center text-gray-500">No books found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Book List as cards on mobile view --}}
<div class="m-2 md:hidden space-y-3">
    @forelse($books as $book)
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-start mb-2">
            <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm flex-1 pr-2">
                {{ $book->title }}
            </a>
            @if($book->stock == 0)
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex-shrink-0">Out of Stock</span>
            @elseif($book->stock <= 3)
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 flex-shrink-0">{{ $book->stock }} left</span>
            @else
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex-shrink-0">{{ $book->stock }} in stock</span>
            @endif
        </div>
        
        <div class="text-sm text-gray-500 mb-1">{{ $book->author }}</div>
        
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $book->category->name }}</span>
                <span class="text-sm font-medium text-gray-900">${{ number_format($book->price, 2) }}</span>
            </div>
            
            {{-- actions for admin only --}}
            @if(auth()->user()->isAdmin())
            <div class="flex items-center space-x-3">
                <a href="{{ route('books.edit', $book) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" 
                      class="inline delete-book-form" 
                      data-book-title="{{ $book->title }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
        No books found
    </div>
    @endforelse
</div>

{{-- pagination --}}
<div class="mt-4">
    {{ $books->links() }}
</div>

{{-- Confirmation popup --}}
<x-confirm-modal />
@endsection