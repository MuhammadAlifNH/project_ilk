<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
            .tombol {
              top: 10px;
              left: 10px;
              background-color: #3baa9b;
              color: white;
              padding: 10px 20px;
              border: none;
              border-radius: 2px;
              cursor: pointer;
              z-index: 2;
              transition: background-color 0.3s ease;
            }
            
            .tombol:hover {
              background-color: #458ba0;
            }

            .back-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2rem;
                height: 2rem;
                border-radius: 50%;
                background-color: #f3f4f6;
                transition: all 0.2s ease;
            }

            .back-button:hover {
                background-color: #e5e7eb;
                transform: scale(1.1);
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Topbar -->
            <header class="bg-white shadow flex items-center justify-between px-4 py-3">
                <div class="flex items-center">
                    <!-- Logo dan Nama Aplikasi -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="/images/logo.png" alt="Logo" class="h-12">
                        </a>
                    </div>
                </div>

                <!-- Informasi Akun Pengguna -->
                <div class="flex items-center">
                    <span class="mr-2">
                        Halo, {{ Auth::user()->name }}
                        <span class="text-xs text-gray-500 ml-1">
                            ({{ ucfirst(Auth::user()->role) }})
                        </span>
                    </span>
                    <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="Profile" class="h-8 w-8 rounded-full">
                    
                    <!-- Tombol Notifikasi -->
                    <button class="relative ml-4 text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                    </button>
                </div>
            </header>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}" class="back-button">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                            <h1 class="text-xl font-semibold text-gray-800">
                                {{ $header }}
                            </h1>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>