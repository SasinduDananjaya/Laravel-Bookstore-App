<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bookstore') }} - @yield('title')</title>
    <script 
        src="https://cdn.tailwindcss.com">
    </script>

    <link rel="stylesheet" href="{{ asset('flash-messages/flash-messages.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        {{-- Navigation --}}
        <nav class="bg-white shadow-lg" x-data="{ mobileMenuOpen: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('books.index') }}" class="flex items-center space-x-2">
                                <img src="{{ asset('images/bookstore-app-logo.webp') }}" 
                                    alt="Bookstore Logo" 
                                    class="w-10 h-10 object-contain">
                                <span class="text-xl font-bold text-blue-600">Bookstore</span>
                            </a>
                        </div>
                        
                        @auth
                        {{-- Desktop navigation --}}
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" 
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Dashboard
                            </a>
                            @endif

                            <a href="{{ route('books.index') }}" 
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('books.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Books
                            </a>

                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('categories.index') }}" 
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                Categories
                            </a>
                            @endif

                            <a href="{{ route('borrowings.index') }}" 
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('borrowings.*') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                                {{ auth()->user()->isAdmin() ? 'Borrowings' : 'My Borrowings' }}
                            </a>
                        </div>
                        @endauth
                    </div>
                    
                    {{-- Desktop user menu --}}
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @auth
                        <div class="relative flex items-center space-x-4">
                            <span class="text-gray-700">
                                <img src="{{ asset('images/user-icon.webp') }}"
                                    alt="User Icon" 
                                    class="w-6 h-6 inline-block">
                                {{ Auth::user()->name }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="font-semibold text-red-500 hover:text-red-700 flex items-center gap-2">
                                    Logout
                                    <img src="{{ asset('images/logout-icon.webp') }}" 
                                        alt="Logout Icon" 
                                        class="w-4 h-4 inline-block">
                                </button>
                            </form>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 mr-4">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700">Register</a>
                        @endauth
                    </div>

                    {{-- Mobile hamburger button --}}
                    <div class="flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" 
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" 
                                    class="inline-flex" 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="2" 
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" 
                                    class="hidden" 
                                    stroke-linecap="round" 
                                    stroke-linejoin="round" 
                                    stroke-width="2" 
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile menu --}}
            <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="hidden sm:hidden">
                @auth
                <div class="pt-2 pb-3 space-y-1">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                        Dashboard
                    </a>
                    @endif

                    <a href="{{ route('books.index') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('books.*') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                        Books
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.index') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('categories.*') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                        Categories
                    </a>
                    @endif

                    <a href="{{ route('borrowings.index') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('borrowings.*') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                        {{ auth()->user()->isAdmin() ? 'Borrowings' : 'My Borrowings' }}
                    </a>
                </div>

                {{-- Mobile user section --}}
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <img src="{{ asset('images/user-icon.webp') }}"
                            alt="User Icon" 
                            class="w-8 h-8">
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-red-500 hover:text-red-700 hover:bg-gray-50 hover:border-gray-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                {{-- Guest mobile menu --}}
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('login') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300">
                        Register
                    </a>
                </div>
                @endauth
            </div>
        </nav>

        {{-- page content --}}
        <main class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{-- flash messages --}}
                <div class="m-2">

                    <x-flash-message />
                </div>

                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('flash-messages/flash-messages.js') }}"></script>
</body>
</html>