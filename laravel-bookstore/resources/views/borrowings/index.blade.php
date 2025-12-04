@extends('layouts.app')

@section('title', auth()->user()->isAdmin() ? 'Borrowings' : 'My Borrowings')

@section('content')
{{-- Book borrowings page --}}
<div class="m-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
        {{ auth()->user()->isAdmin() ? 'Book Borrowings' : 'My Borrowings' }}
    </h1>
    
    {{-- issue book btn for admin --}}
    @if(auth()->user()->isAdmin())
    <a href="{{ route('borrowings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center text-sm sm:text-base">
        + Issue New Book
    </a>
    @endif
</div>

{{-- Borrowing stats for members --}}
@if(auth()->user()->isMember())
<div class="m-2 grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
    @php
        $activeBorrowings = $borrowings->where('status', 'issued')->count();
        $overdueBorrowings = $borrowings->filter(fn($b) => $b->status === 'issued' && $b->due_date < now())->count();
        $returnedBorrowings = $borrowings->where('status', 'returned')->count();
    @endphp
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 sm:p-4 rounded">
        <div class="flex items-center">
            <span class="text-xl sm:text-2xl mr-2 sm:mr-3">📖</span>
            <div>
                <p class="text-xs sm:text-sm text-yellow-800">Currently Borrowed</p>
                <p class="text-xl sm:text-2xl font-bold text-yellow-900">{{ $activeBorrowings }}</p>
            </div>
        </div>
    </div>
    <div class="bg-red-50 border-l-4 border-red-400 p-3 sm:p-4 rounded">
        <div class="flex items-center">
            <span class="text-xl sm:text-2xl mr-2 sm:mr-3">⚠️</span>
            <div>
                <p class="text-xs sm:text-sm text-red-800">Overdue</p>
                <p class="text-xl sm:text-2xl font-bold text-red-900">{{ $overdueBorrowings }}</p>
            </div>
        </div>
    </div>
    <div class="bg-green-50 border-l-4 border-green-400 p-3 sm:p-4 rounded">
        <div class="flex items-center">
            <span class="text-xl sm:text-2xl mr-2 sm:mr-3">✅</span>
            <div>
                <p class="text-xs sm:text-sm text-green-800">Returned</p>
                <p class="text-xl sm:text-2xl font-bold text-green-900">{{ $returnedBorrowings }}</p>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Book borrowings filters --}}
<div class="m-2 bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
    <form method="GET" action="{{ route('borrowings.index') }}" 
          class="grid grid-cols-1 sm:grid-cols-{{ auth()->user()->isAdmin() ? '3' : '2' }} gap-3 sm:gap-4">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" 
                    class="text-base filter-input w-full rounded-xl p-1 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Status</option>
                <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
            </select>
        </div>

        {{-- Member filter for admin only --}}
        @if(auth()->user()->isAdmin())
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Member</label>
            <select name="user_id" 
                    class="text-base filter-input w-full rounded-xl p-1 border-2 border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">All Members</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="flex items-end space-x-2">
            <button id="borrowingsFilterBtn" 
                    type="submit" 
                    class="flex-1 sm:flex-none bg-blue-600 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed text-sm sm:text-base" 
                    disabled>
                Filter
            </button>

            <a id="clearBtn" 
               href="{{ route('borrowings.index') }}" 
               class="flex-1 sm:flex-none text-center bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed pointer-events-none text-sm sm:text-base">
                Clear
            </a>
        </div>

    </form>
</div>

{{-- Desktop borrowings table view --}}
<div class="m-2 hidden lg:block bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Book</th>
                {{-- Member column for admin Only --}}
                @if(auth()->user()->isAdmin())
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member</th>
                @endif
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issue Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                
                {{-- Actions column for admin Only --}}
                @if(auth()->user()->isAdmin())
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($borrowings as $borrowing)
            @php
                $isOverdue = $borrowing->status === 'issued' && $borrowing->due_date < now();
                $isDueSoon = $borrowing->status === 'issued' && $borrowing->due_date->diffInDays(now()) <= 3 && !$isOverdue;
                $daysUntilDue = floor(now()->diffInDays($borrowing->due_date, false));
            @endphp
            <tr class="{{ $isOverdue ? 'bg-red-50' : ($isDueSoon ? 'bg-yellow-50' : '') }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</div>
                    <div class="text-xs text-gray-500">{{ $borrowing->book->author }}</div>
                </td>
                
                {{-- Members for admin --}}
                @if(auth()->user()->isAdmin())
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $borrowing->user->name }}
                </td>
                @endif
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $borrowing->issue_date->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">{{ $borrowing->due_date->format('M d, Y') }}</div>
                    
                    @if($borrowing->status === 'issued')
                        @if($isOverdue)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                            🚨 Overdue by {{ abs($daysUntilDue) }} days
                        </span>
                        @elseif($isDueSoon)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            ⏰ Due in {{ $daysUntilDue }} days
                        </span>
                        @elseif($borrowing->due_date->isToday())
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                            📅 Due Today!
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                            📆 {{ $daysUntilDue }} days remaining
                        </span>
                        @endif
                    @elseif($borrowing->status === 'returned')
                        <span class="text-xs text-gray-500">
                            Returned: {{ $borrowing->return_date->format('M d, Y') }}
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($borrowing->status === 'issued')
                        @if($isOverdue)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Overdue
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Issued
                        </span>
                        @endif
                    @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Returned
                    </span>
                    @endif
                </td>
                
                {{-- Actions - admin Only --}}
                @if(auth()->user()->isAdmin())
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    @if($borrowing->status === 'issued')
                    <form action="{{ route('borrowings.return', $borrowing) }}" 
                          method="POST" 
                          class="inline return-borrowing-form"
                          data-book-title="{{ $borrowing->book->title }}"
                          data-member-name="{{ $borrowing->user->name }}"
                          data-is-overdue="{{ $isOverdue ? 'true' : 'false' }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Return</button>
                    </form>
                    @endif
                    <form action="{{ route('borrowings.destroy', $borrowing) }}" 
                          method="POST" 
                          class="inline delete-borrowing-form"
                          data-book-title="{{ $borrowing->book->title }}"
                          data-member-name="{{ $borrowing->user->name }}"
                          data-status="{{ $borrowing->status }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->isAdmin() ? 6 : 4 }}" class="px-6 py-4 text-center text-gray-500">
                    {{ auth()->user()->isMember() ? 'You have no borrowing history.' : 'No borrowing records found' }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile book borrowings cards view --}}
<div class="m-2 lg:hidden space-y-3">
    @forelse($borrowings as $borrowing)
    @php
        $isOverdue = $borrowing->status === 'issued' && $borrowing->due_date < now();
        $isDueSoon = $borrowing->status === 'issued' && $borrowing->due_date->diffInDays(now()) <= 3 && !$isOverdue;
        $daysUntilDue = floor(now()->diffInDays($borrowing->due_date, false));
    @endphp
    <div class="bg-white shadow rounded-lg p-4 {{ $isOverdue ? 'border-l-4 border-red-500' : ($isDueSoon ? 'border-l-4 border-yellow-500' : '') }}">
      
        <div class="flex justify-between items-start mb-2">
            <div class="flex-1 pr-2">
                <h3 class="text-sm font-medium text-gray-900">{{ $borrowing->book->title }}</h3>
                <p class="text-xs text-gray-500">{{ $borrowing->book->author }}</p>
            </div>
            <div class="flex-shrink-0">
                @if($borrowing->status === 'issued')
                    @if($isOverdue)
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        Overdue
                    </span>
                    @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Issued
                    </span>
                    @endif
                @else
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    Returned
                </span>
                @endif
            </div>
        </div>

        {{-- Member name for admin --}}
        @if(auth()->user()->isAdmin())
        <div class="mb-2">
            <span class="text-xs text-gray-500">Member: </span>
            <span class="text-xs font-medium text-gray-700">{{ $borrowing->user->name }}</span>
        </div>
        @endif

        <div class="grid grid-cols-2 gap-2 mb-2 text-xs">
            <div>
                <span class="text-gray-500">Issued:</span>
                <span class="font-medium text-gray-700">{{ $borrowing->issue_date->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="text-gray-500">Due:</span>
                <span class="font-medium text-gray-700">{{ $borrowing->due_date->format('M d, Y') }}</span>
            </div>
        </div>

        @if($borrowing->status === 'issued')
        <div class="mb-3">
            @if($isOverdue)
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                🚨 Overdue by {{ abs($daysUntilDue) }} days
            </span>
            @elseif($isDueSoon)
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                ⏰ Due in {{ $daysUntilDue }} days
            </span>
            @elseif($borrowing->due_date->isToday())
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                📅 Due Today!
            </span>
            @else
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                📆 {{ $daysUntilDue }} days remaining
            </span>
            @endif
        </div>
        @elseif($borrowing->status === 'returned')
        <div class="mb-3">
            <span class="text-xs text-gray-500">
                Returned: {{ $borrowing->return_date->format('M d, Y') }}
            </span>
        </div>
        @endif

        {{-- Actions for admin --}}
        @if(auth()->user()->isAdmin())
        <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
            @if($borrowing->status === 'issued')
            <form action="{{ route('borrowings.return', $borrowing) }}" 
                  method="POST" 
                  class="inline return-borrowing-form"
                  data-book-title="{{ $borrowing->book->title }}"
                  data-member-name="{{ $borrowing->user->name }}"
                  data-is-overdue="{{ $isOverdue ? 'true' : 'false' }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">Return</button>
            </form>
            @endif
            <form action="{{ route('borrowings.destroy', $borrowing) }}" 
                  method="POST" 
                  class="inline delete-borrowing-form"
                  data-book-title="{{ $borrowing->book->title }}"
                  data-member-name="{{ $borrowing->user->name }}"
                  data-status="{{ $borrowing->status }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white shadow rounded-lg p-4 text-center text-gray-500 text-sm">
        {{ auth()->user()->isMember() ? 'You have no borrowing history.' : 'No borrowing records found' }}
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $borrowings->links() }}
</div>

{{-- Member reminder messages --}}
@if(auth()->user()->isMember())
    @php
        $hasOverdue = $borrowings->contains(fn($b) => $b->status === 'issued' && $b->due_date < now());
    @endphp
    @if($hasOverdue)
    <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-3 sm:p-4 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <span class="text-red-400 text-lg sm:text-xl">⚠️</span>
            </div>
            <div class="ml-2 sm:ml-3">
                <h3 class="text-xs sm:text-sm font-medium text-red-800">You have overdue books!</h3>
                <p class="mt-1 text-xs sm:text-sm text-red-700">
                    Please return your overdue books as soon as possible to avoid any penalties.
                </p>
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Confirmation popup --}}
<x-confirm-modal />
@endsection