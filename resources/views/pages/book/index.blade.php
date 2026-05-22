<x-layouts::main :title="__('Buku')">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Buku</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">{{ $books->count() }} Buku Terdaftar</p>
        </div>
        <a href="{{ route((auth()->user()->role === 'admin' ? 'admin' : 'staff') . '.books.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors shadow-md">
            <i class="fas fa-plus text-lg"></i>
            Tambah Buku
        </a>
    </div>

    <!-- Books Table -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-neutral-50 dark:bg-neutral-700 border-b border-neutral-200 dark:border-neutral-600">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Buku</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Pengarang</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Stok</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-neutral-200 dark:divide-neutral-600">
                    @forelse($books as $book)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <!-- Book Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-book text-blue-600 dark:text-blue-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-900 dark:text-white">{{ $book->name }}</p>
                                        <p class="text-xs text-neutral-600 dark:text-neutral-400">{{ $book->isbn ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $book->category }}</span>
                            </td>

                            <!-- Author -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $book->author ?? '-' }}</span>
                            </td>

                            <!-- Stock -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $book->stock }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                 <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold @if($book->status === 'Tersedia') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 @endif">
                                     <i class="fas fa-circle text-xs"></i>
                                     {{ $book->status }}
                                 </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route((auth()->user()->role === 'admin' ? 'admin' : 'staff') . '.books.edit', $book->id) }}" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg">
                                        <i class="fas fa-pen text-lg"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route((auth()->user()->role === 'admin' ? 'admin' : 'staff') . '.books.destroy', $book->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-book-open text-4xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                                    <p class="text-neutral-600 dark:text-neutral-400 text-lg">Belum ada buku</p>
                                    <p class="text-neutral-500 dark:text-neutral-500 text-sm mt-1">Mulai dengan menambahkan buku pertama Anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::main>
