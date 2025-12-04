@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
    <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-900">← Back to Books</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Book Details</h2>
        <dl class="grid grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Author</dt>
                <dd class="mt-1 text-lg text-gray-900">{{ $book->author }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-lg text-gray-900">{{ $book->category->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Price</dt>
                <dd class="mt-1 text-lg text-gray-900">${{ number_format($book->price, 2) }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Stock</dt>
                <dd class="mt-1">
                    @if($book->stock == 0)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                    @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">{{ $book->stock }} available</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Added On</dt>
                <dd class="mt-1 text-lg text-gray-900">{{ $book->created_at->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                <dd class="mt-1 text-lg text-gray-900">{{ $book->updated_at->format('M d, Y') }}</dd>
            </div>
        </dl>

        {{-- edit, issue book actions for admin --}}
        @if(auth()->user()->isAdmin())
        <div class="mt-6 flex space-x-3">
            <a href="{{ route('books.edit', $book) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Book
            </a>
            @if($book->isAvailable())
            <a href="{{ route('borrowings.create') }}?book_id={{ $book->id }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Issue Book
            </a>
            @endif
        </div>
        @endif
    </div>

    {{-- all users borrowing history for admin --}}
    @if(auth()->user()->isAdmin())
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Borrowing History</h2>
        @if($book->borrowings->count() > 0)
        <ul class="space-y-3">
            @foreach($book->borrowings->take(5) as $borrowing)
            <li class="border-b pb-2">
                <p class="font-medium text-gray-900">{{ $borrowing->user->name }}</p>
                <p class="text-sm text-gray-500">
                    {{ $borrowing->issue_date->format('M d, Y') }}
                    <span class="px-2 py-0.5 text-xs rounded-full 
                        {{ $borrowing->status === 'issued' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($borrowing->status) }}
                    </span>
                </p>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500">No borrowing history</p>
        @endif
    </div>
    @endif
</div>
@endsection