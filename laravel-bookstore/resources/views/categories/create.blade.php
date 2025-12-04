@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="m-2 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Add New Category</h1>
</div>

<div class="m-2 bg-white shadow rounded-lg p-6 max-w-lg">
    {{-- create category form --}}
    <form id="addBookCategoryForm" action="{{ route('categories.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="w-full p-2 rounded-md border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancel
            </a>
            <button id="createBookCategoryBtn" type="submit" disabled
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection