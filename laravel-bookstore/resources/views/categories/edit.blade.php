@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Category: {{ $category->name }}</h1>
</div>

<div class="bg-white shadow rounded-lg p-6 max-w-lg">
    {{-- edit category form --}}
    <form id="editBookCategoryForm" action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancel
            </a>
            <button id="updateBookCategoryBtn" type="submit" disabled
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection