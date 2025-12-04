@extends('layouts.app')

@section('title', 'Issue Book')

@section('content')
<div class="m-2 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Issue New Book</h1>
</div>

<div class="m-2 bg-white shadow rounded-lg p-6">
    {{-- books issue form --}}
    <form id="issueBorrowingBookForm" action="{{ route('borrowings.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Book <span class="text-red-500">*</span></label>
                <select name="book_id" id="book_id" 
                        class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('book_id') border-red-500 @enderror">
                    <option value="">Select a book</option>
                    @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ (old('book_id') ?? request('book_id')) == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} ({{ $book->stock }} available)
                    </option>
                    @endforeach
                </select>
                @error('book_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Member <span class="text-red-500">*</span></label>
                <select name="user_id" id="user_id" 
                        class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('user_id') border-red-500 @enderror">
                    <option value="">Select a member</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                    @endforeach
                </select>
                @error('user_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="issue_date" class="block text-sm font-medium text-gray-700 mb-1">Issue Date <span class="text-red-500">*</span></label>
                <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', date('Y-m-d')) }}"
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('issue_date') border-red-500 @enderror">
                @error('issue_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date <span class="text-red-500">*</span></label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}"
                       class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('due_date') border-red-500 @enderror">
                @error('due_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full rounded-md p-2 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('borrowings.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                Cancel
            </a>
            <button id="issueBookBtn" type="submit" disabled
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">
                Issue Book
            </button>
        </div>
    </form>
</div>
@endsection