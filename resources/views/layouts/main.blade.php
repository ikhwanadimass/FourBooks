<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'StoKun - Inventory Management' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVJkEZSMUkrQ6usKnu8UETLon7ifzUvF+/SFg/0ZS9Rm4Or4tS5hSLw31PEkMhs2ryYsSan2SkA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-neutral-50 dark:bg-neutral-900">
    <!-- Sidebar Container -->
    <div class="flex min-h-screen overflow-x-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed left-0 top-0 h-screen w-64 lg:w-72 bg-[#3B7597] text-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
            <!-- Sidebar Content -->
            <div class="flex flex-col h-full">
                <!-- Logo Section -->
                <div class="flex items-center justify-between p-6 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/NoBG-NoText.png') }}" alt="Fourbooks Logo" class="h-10 w-auto">
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight">Fourbooks</h1>
                    </div>
                    <!-- Close button -->
                    <button id="closeSidebar" class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Menu Section -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <div class="text-xs font-semibold text-white/70 uppercase tracking-wider px-2 mb-4">Menu</div>

                    @if (auth()->user()->role === 'user')
                        <!-- Dashboard Link (User) -->
                        <a href="{{ route('user.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.dashboard') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-th text-lg"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Katalog Buku -->
                        <a href="{{ route('user.catalog') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.catalog') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-book text-lg"></i>
                            <span>Katalog Buku</span>
                        </a>

                        <!-- Keranjang Pinjam -->
                        <a href="{{ route('user.cart') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.cart') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span>Keranjang Pinjam</span>
                        </a>

                        <!-- Riwayat Peminjaman -->
                        <a href="{{ route('user.history') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('user.history') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-history text-lg"></i>
                            <span>Riwayat Peminjaman</span>
                        </a>
                    @else
                        @php
                            $rolePrefix = auth()->user()->role === 'admin' ? 'admin' : 'staff';
                        @endphp

                        <!-- Dashboard Link -->
                        <a href="{{ route($rolePrefix . '.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs($rolePrefix . '.dashboard') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-th text-lg"></i>
                            <span>Dashboard</span>
                        </a>

                        <!-- Book Link -->
                        <a href="{{ route($rolePrefix . '.books.index') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs($rolePrefix . '.books.*') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-book text-lg"></i>
                            <span>Buku</span>
                        </a>

                        <!-- Loan List Link -->
                        <a href="{{ route($rolePrefix . '.loans.index') }}"
                            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs($rolePrefix . '.loans.*') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                            <i class="fas fa-list text-lg"></i>
                            <span>Daftar Peminjaman</span>
                        </a>

                        <!-- Manajemen Akun Link (Admin Only) -->
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.accounts.index') }}"
                                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.accounts.*') ? 'bg-white/20 font-bold' : 'text-white/90 hover:bg-white/10' }} rounded-lg transition-colors font-medium">
                                <i class="fas fa-users text-lg"></i>
                                <span>Manajemen akun</span>
                            </a>
                        @endif
                    @endif
                </nav>

                <!-- User Section at Bottom -->
                <div class="border-t border-white/10 p-4">
                    <div
                        class="flex items-center gap-3 p-3 bg-white/10 hover:bg-white/15 transition-colors cursor-pointer">
                        <div
                            class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#3B7597] font-semibold">
                            {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-white/70 truncate">{{ auth()->user()->email ?? 'user@example.com' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div id="mainContent"
            class="flex-1 flex flex-col w-full lg:w-auto transition-transform duration-300 ease-in-out pt-24">
            <!-- Header -->
            <header class="fixed top-0 inset-x-0 bg-[#0c4366] text-white shadow-md z-50">
                <div class="px-4 lg:px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Hamburger Menu Button -->
                        <button id="menuToggle" class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        @php
                            $role = auth()->user()->role;
                            $roleLabel = $role === 'admin' ? 'Admin' : ($role === 'staff' ? 'Staff' : 'Anggota');

                            $displayTitle = $title ?? 'Dashboard';
                            $cleanTitle = preg_replace('/^Fourbooks\s*(-\s*)?/i', '', $displayTitle);

                            if (
                                empty($cleanTitle) ||
                                strtolower($cleanTitle) === 'dashboard' ||
                                strtolower($cleanTitle) === strtolower($roleLabel)
                            ) {
                                $headerTitle = 'Fourbooks - ' . $roleLabel;
                            } else {
                                $headerTitle = 'Fourbooks - ' . $roleLabel . ' - ' . $cleanTitle;
                            }
                        @endphp
                        <span class="text-white font-bold text-xl tracking-tight ml-1">{{ $headerTitle }}</span>
                    </div>

                    <!-- Search Bar -->
                    @if (auth()->user()->role !== 'user')
                       <form action="{{ route(auth()->user()->role . '.books.index') }}" method="GET"
                            class="hidden md:flex flex-1 max-w-md mx-4 lg:mx-8">
                            <div class="relative w-full">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari Barang, Merek, Dan Lain-Lainnya..."
                                    class="w-full px-4 py-2 pr-10 bg-white/15 border-0 rounded-lg text-white placeholder-blue-100 focus:outline-none focus:ring-2 focus:ring-white/50">
                                <button type="submit" class="absolute right-3 top-2.5 text-blue-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Mobile Search Icon -->
                        @if (auth()->user()->role !== 'user')
                            <button class="md:hidden text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                <i class="fas fa-search text-lg"></i>
                            </button>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <!-- Profile Button -->
                            <button @click="open = !open" @click.outside="open = false"
                                class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                                <i class="fas fa-user-circle text-2xl"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-800 rounded-lg shadow-lg overflow-hidden z-50"
                                style="display: none;">
                                <!-- User Info -->
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-neutral-700">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ auth()->user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-gray-600 dark:text-neutral-400 truncate">
                                        {{ auth()->user()->email ?? 'user@example.com' }}</p>
                                </div>

                                <!-- Menu Items -->
                                <div class="py-2 divide-y divide-gray-100 dark:divide-neutral-700">
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}"
                                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors font-medium">
                                            <i class="fas fa-cog text-gray-400 dark:text-neutral-400 w-5"></i>
                                            <span>Settings</span>
                                        </a>
                                    </div>

                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit"
                                                class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors font-medium">
                                                <i class="fas fa-sign-out-alt text-red-500 w-5"></i>
                                                <span>Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 px-4 lg:px-8 py-6 lg:py-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Overlay for Sidebar -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-transparent z-40 hidden"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const menuToggle = document.getElementById('menuToggle');
            const closeSidebar = document.getElementById('closeSidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.add('translate-x-64', 'lg:translate-x-72');
                sidebarOverlay.classList.remove('hidden');
            }

            function closeSidebarFunc() {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('translate-x-64', 'lg:translate-x-72');
                sidebarOverlay.classList.add('hidden');
            }

            // Toggle sidebar on menu button click
            menuToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebarFunc();
                }
            });

            // Close sidebar on close button click
            closeSidebar.addEventListener('click', closeSidebarFunc);

            // Close sidebar when clicking on overlay
            sidebarOverlay.addEventListener('click', closeSidebarFunc);

            // Close sidebar on link click
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', closeSidebarFunc);
            });
        });
    </script>
</body>

</html>
