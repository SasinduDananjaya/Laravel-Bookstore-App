@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
<div class="m-2 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Book</h1>
</div>

<div class="m-2 bg-white shadow rounded-lg p-6">
    {{-- Add book form --}}
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author <span class="text-red-500">*</span></label>
                <input type="text" name="author" id="author" value="{{ old('author') }}" 
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('author') border-red-500 @enderror">
                @error('author')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="book_category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <select name="book_category_id" id="book_category_id" 
                        class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('book_category_id') border-red-500 @enderror">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('book_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('book_category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="0"
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stock') border-red-500 @enderror">
                @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('books.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancel
            </a>
            <button id="createBookBtn" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Book
            </button>
        </div>
    </form>
</div>
@endsection