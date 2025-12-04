@extends('layouts.app')

@section('title', 'Categories')

@section('content')
{{-- Book categories page --}}
<div class="m-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Book Categories</h1>
    <a href="{{ route('categories.create') }}" class="text-sm sm:text-base bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
        + Add Category
    </a>
</div>

{{-- Desktop book categories table view --}}
<div class="m-2 hidden md:block bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Books Count</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($categories as $category)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    @if($category->books_count > 0)
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                        {{ $category->books_count }} book(s)
                    </span>
                    @else
                    <span class="text-gray-400">No books</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" 
                          method="POST" 
                          class="inline delete-category-form"
                          data-category-name="{{ $category->name }}"
                          data-books-count="{{ $category->books_count }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No categories found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Book categories as cards in mobile view --}}
<div class="m-2 md:hidden space-y-3">
    @forelse($categories as $category)
    <div class="bg-white shadow rounded-lg p-4">
     
        <div class="flex justify-between items-start mb-2">
            <h3 class="text-sm font-medium text-gray-900 flex-1 pr-2">{{ $category->name }}</h3>
            @if($category->books_count > 0)
            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs flex-shrink-0">
                {{ $category->books_count }} book(s)
            </span>
            @else
            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-xs flex-shrink-0">
                No books
            </span>
            @endif
        </div>
        
        <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs text-gray-500">
                📅 {{ $category->created_at->format('M d, Y') }}
            </span>
            <div class="flex items-center space-x-3">
                <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" 
                      method="POST" 
                      class="inline delete-category-form"
                      data-category-name="{{ $category->name }}"
                      data-books-count="{{ $category->books_count }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500">
        No categories found
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $categories->links() }}
</div>

{{-- confirmation Popup --}}
<x-confirm-modal />
@endsection