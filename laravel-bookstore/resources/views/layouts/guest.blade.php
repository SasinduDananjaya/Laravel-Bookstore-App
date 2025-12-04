<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bookstore') }}</title>

        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-6 sm:py-8 md:py-12 bg-gray-100">
            
            <!-- Logo Section -->
            <div class="mb-4 sm:mb-6">
                <a href="/" class="block">
                    <img 
                        src="{{ asset('images/bookstore-app-logo.webp') }}" 
                        alt="Logo" 
                        class="w-32 h-auto sm:w-40 md:w-48 mx-auto"
                    >
                </a>    
            </div>

            {{-- main login / register card --}}
            <div class="w-full max-w-sm sm:max-w-md px-4 py-5 sm:px-6 sm:py-6 bg-white shadow-md rounded-lg sm:rounded-xl">
                {{ $slot }}
            </div>

            {{-- footer --}}
            <div class="mt-4 sm:mt-6 text-center">
                <p class="text-xs sm:text-sm text-gray-500">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Bookstore') }}. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>