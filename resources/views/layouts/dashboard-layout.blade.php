<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Dashboard') }}</title>
    <!-- Include Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">
    <!-- Topbar -->
    <header class="bg-white shadow flex items-center justify-between px-4 py-3">
        <div class="flex items-center">
            <!-- Tombol toggle sidebar untuk mobile -->
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                <svg x-show="!sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Logo dan Nama Aplikasi -->
            <div class="flex items-center ml-4">
                <a href="{{ route('dashboard') }}" class="flex items-center">
        <img src="/images/logo.png" alt="Logo" class="h-12">
        <div class="ml-2">
           
        </div>
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
    <img src="{{ Auth::user()->profile_photo_url ?? asset('images/profile-placeholder.png') }}" alt="Profile" class="h-8 w-8 rounded-full">
</div>

    </header>
    <div class="flex">
        <!-- Sidebar -->
        <!-- Pada layar desktop, sidebar dapat di-collapse dengan mengubah lebarnya -->
        <aside class="bg-white h-screen shadow-md transition-all duration-300 overflow-hidden"
               :class="sidebarOpen ? 'w-64' : 'w-16'">
            <!-- Header sidebar -->
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                <div x-show="sidebarOpen" class="font-bold text-lg">
                    Menu
                </div>
                <!-- Tombol toggle sidebar untuk desktop -->
                <button @click="sidebarOpen = !sidebarOpen" class="focus:outline-none hidden md:block">
                    <svg x-show="sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <svg x-show="!sidebarOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- Menu Sidebar -->
    <nav class="mt-4">
        <!-- Menu Dashboard -->
          <!-- Sub-menu Kelola Data -->
          <div x-data="{ open: false }">
                <!-- Tombol Sub-menu -->
                <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-200 transition-colors focus:outline-none">
                    <div class="flex items-center">
                        <!-- Ikon Folder atau sejenisnya -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7" />
                        </svg>
                        <!-- Teks Kelola Data -->
                        <span x-show="sidebarOpen" class="ml-3 text-lg font-medium">Kelola Data</span>
                    </div>
                    <!-- Panah Rotasi -->
                    <svg x-show="sidebarOpen"
                         :class="{ 'transform rotate-90': open }"
                         class="w-4 h-4 transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Isi Sub-menu -->
                <div x-show="open" x-collapse>
                    <!-- Kelola Pengguna -->
                    <a href="{{ route('users.index') }}"
                    class="block py-2 px-4 text-gray-600 hover:bg-blue-300">
                        <!-- Ikon Pengguna -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1
                                     m8-3a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-2">Kelola Pengguna</span>
                    </a>
                    <!-- Kelola Fakultas -->
                    <a href="{{ route('fakultas.index') }}"
                    class="block py-2 px-4 text-gray-600 hover:bg-blue-300">
                        <!-- Ikon Fakultas -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" 
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l6.16-3.422a12.083 12.083 0 01.84 6.062L12 21" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 14l-6.16-3.422a12.083 12.083 0 00-.84 6.062L12 21" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-2">Kelola Fakultas</span>
                    </a>
                    <!-- Kelola Lab -->
                    <a href="{{ route('labs.index') }}"
                    class="block py-2 px-4 text-gray-600 hover:bg-blue-300">
                        <!-- Ikon Lab -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 16V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8M7 12h10" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-2">Kelola Lab</span>
                    </a>
                    <!-- Kelola Perangkat Keras -->
                    <a href="{{ route('perkeras.index') }}"
                    class="block py-2 px-4 text-gray-600 hover:bg-blue-300">
                        <!-- Ikon Hardware -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9.75 17L9 21h6l-.75-4
                                     M4 6h16M4 6a2 2 0 012-2h12a2 2 0 012 2M4 6v10a2 2 0 002 2h12
                                     a2 2 0 002-2V6" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-2">Kelola Perangkat Keras</span>
                    </a>
                    <!-- Kelola Perangkat Lunak -->
                    <a href="{{ route('perlunak.index') }}"
                    class="block py-2 px-4 text-gray-600 hover:bg-blue-300">
                        <!-- Ikon Software -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 18l6-6-6-6M8 6l-6 6 6 6" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-2">Kelola Perangkat Lunak</span>
                    </a>
                </div>
        <!-- Menu Profile -->
        <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-200">
            <span x-show="sidebarOpen">Profile</span>
            <span x-show="!sidebarOpen" title="Profile">
                <!-- Contoh icon profile -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14a4 4 0 01-8 0M12 2a4 4 0 014 4 4 4 0 11-8 0 4 4 0 014-4z"/>
                </svg>
            </span>
        </a>
        <!-- Menu Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="w-full text-left py-2 px-4 text-gray-700 hover:bg-gray-200 transition-colors">
                <span x-show="sidebarOpen">Logout</span>
                <span x-show="!sidebarOpen" title="Logout">
                    <!-- Contoh icon logout -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                    </svg>
                </span>
            </button>
        </form>
    </nav>
</aside>
    
        <!-- Konten Utama -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
