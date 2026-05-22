<x-layouts::main :title="__('Fourbooks - Staff')">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Dashboard</h1>
        <p class="text-neutral-600 dark:text-neutral-400 mt-2">Ringkasan Toko Anda</p>
    </div>

    <!-- Monitoring Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Buku Dipinjam (Aktif) -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Total Buku Dipinjam</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">{{ $booksCount ?? 0 }}</p>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-2">(Aktif)</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Peminjaman Baru Hari Ini -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Peminjaman Baru Hari Ini</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">{{ $loansToday ?? 0 }}</p>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-2">Keaktifan sirkulasi harian</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus-circle text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Buku Terlambat & Total Denda -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-red-500">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Buku Terlambat</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2">{{ $lateCount ?? 0 }}</p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-2">Denda: {{ isset($totalLateFines) ? 'Rp ' . number_format(abs($totalLateFines), 0, ',', '.') : 'Rp 0' }}</p>
                        <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-2">Aktif Peminjaman: {{ $loansCount ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Section -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Aktivitas Terbaru</h3>
        </div>

        <!-- Activity List -->
        <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
            @forelse($activities as $activity)
                @php
                    $badgeClasses = $activity->status === 'returned'
                        ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400'
                        : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
                @endphp
                <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-10 h-10 {{ $badgeClasses }} rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-{{ $activity->icon }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                    <span class="font-semibold">{{ $activity->user }}</span> {{ $activity->action }} <span class="italic">'{{ $activity->book }}'</span>
                                </p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">{{ $activity->timeLabel }}</p>
                            </div>
                        </div>
                        @if($activity->actionRoute)
                            <form method="POST" action="{{ route(auth()->user()->role . '.loans.' . $activity->actionRoute, $activity->id) }}" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-{{ $activity->color }}-500 hover:bg-{{ $activity->color }}-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    {{ $activity->buttonLabel }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-neutral-600 dark:text-neutral-400">
                    Tidak ada aktivitas terbaru untuk ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts::main>
