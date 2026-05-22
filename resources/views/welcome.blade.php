<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fourbooks - Sistem Manajemen Perpustakaan</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="bg-white dark:bg-[#0a0a0a] text-neutral-900 dark:text-neutral-100 antialiased min-h-screen flex flex-col font-sans">
        
        <header class="absolute top-0 left-0 w-full p-6 lg:px-16 lg:py-8 z-50 flex justify-between items-center">
            <div class="flex items-center gap-3">
                 <img src="{{ asset('images/NoBG-NoText.png') }}" alt="Fourbooks Logo" class="h-10 w-auto">
                <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-white">Fourbooks</h1>
            </div>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        @php
                            $role = auth()->user()->role;
                            $dashboardRoute = $role === 'admin' ? 'admin.dashboard' : ($role === 'staff' ? 'staff.dashboard' : 'user.dashboard');
                        @endphp
                        <a href="{{ route($dashboardRoute) }}" class="px-5 py-2.5 bg-[#3B7597] hover:bg-[#2A5570] transition-colors rounded-xl font-bold text-white shadow-md">
                            Masuk Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 font-bold text-neutral-700 dark:text-neutral-200 hover:text-[#3B7597] transition-colors">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden sm:inline-block px-5 py-2.5 bg-[#3B7597] hover:bg-[#2A5570] transition-colors rounded-xl font-bold text-white shadow-md">
                                Daftar Anggota
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 flex flex-col lg:flex-row w-full min-h-screen">
            
            <div class="flex-1 flex flex-col justify-center px-8 py-32 lg:px-20 xl:px-32 bg-white dark:bg-[#121212] z-10">
                <div class="max-w-2xl">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-50 dark:bg-blue-900/30 text-[#3B7597] dark:text-blue-400 text-sm font-bold tracking-wide mb-6">
                        #1 Digital Library System
                    </span>
                    
                    <h2 class="text-4xl lg:text-6xl font-extrabold mb-6 leading-tight text-neutral-900 dark:text-white">
                        Masa Depan <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3B7597] to-blue-500">Membaca</span> Ada di Sini.
                    </h2>
                    
                    <p class="mb-10 text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed max-w-xl">
                        Fourbooks adalah platform manajemen perpustakaan digital modern. Jelajahi katalog, ajukan pinjaman, dan pantau status buku Anda langsung dari layar perangkat.
                    </p>

                    <div class="space-y-6 mb-12">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-neutral-800 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-book-open text-[#3B7597] text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-neutral-900 dark:text-white">Katalog Buku Terpadu</h3>
                                <p class="text-neutral-600 dark:text-neutral-400 mt-1">Eksplorasi ribuan koleksi dari berbagai kategori dengan pencarian cerdas.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-neutral-800 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bolt text-[#3B7597] text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-neutral-900 dark:text-white">Sistem Peminjaman Praktis</h3>
                                <p class="text-neutral-600 dark:text-neutral-400 mt-1">Ajukan pinjaman secara online dan lunasi denda dengan mudah.</p>
                            </div>
                        </div>
                    </div>

                    @if (!auth()->check())
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#3B7597] hover:bg-[#2A5570] transition-colors rounded-xl font-bold text-white text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Mulai Jelajahi Katalog <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="flex-1 bg-gradient-to-br from-[#3B7597] to-[#142C3D] dark:from-[#142C3D] dark:to-[#07111A] flex items-center justify-center relative overflow-hidden min-h-[400px] lg:min-h-screen">
                
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-5 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[30rem] h-[30rem] rounded-full bg-blue-400 opacity-10 blur-3xl"></div>

                <img src="{{ asset('images/NoBG-NoText.png') }}" alt="Hero Illustration" class="w-2/3 lg:w-3/4 max-w-lg relative z-10 drop-shadow-2xl hover:scale-105 transition-transform duration-700">
                
            </div>

        </main>
    </body>
</html>