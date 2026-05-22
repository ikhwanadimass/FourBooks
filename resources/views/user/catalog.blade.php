<x-layouts::main :title="__('Fourbooks - Katalog Buku')">
    <div x-data="catalogSetup" class="relative">

        <div x-show="notification.show" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-4 right-4 z-50 flex items-center gap-3 w-full max-w-sm p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-2xl border-l-4"
            style="display: none;"
            :class="{
                'border-green-500': notification.type === 'success',
                'border-yellow-500': notification.type === 'warning',
                'border-red-500': notification.type === 'error'
            }">
            <div class="flex-1">
                <p class="text-sm font-semibold text-neutral-900 dark:text-white" x-text="notification.message"></p>
            </div>
            <button @click="notification.show = false"
                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Katalog Buku</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">Cari dan jelajahi seluruh koleksi buku perpustakaan
                kami secara instan.</p>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-md p-6 mb-8 space-y-6">
            <div class="relative w-full">
                <input type="text" x-model="searchQuery" placeholder="Cari Judul Buku, Kategori, atau Penulis..."
                    class="w-full px-5 py-4 pl-12 bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-neutral-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <i class="fas fa-search absolute left-4 top-5 text-neutral-400 text-lg"></i>
            </div>

            <div>
                <span
                    class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-3">Pilih
                    Kategori</span>
                <div class="flex flex-wrap gap-2">
                    <template x-for="cat in categories" :key="cat">
                        <button @click="activeCategory = cat"
                            class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200"
                            :class="activeCategory === cat ? 'bg-blue-500 text-white shadow-md' :
                                'bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600'"
                            x-text="cat"></button>
                    </template>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
            <div
                class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white"
                        x-text="searchQuery ? 'Hasil Pencarian' : 'Rekomendasi Buku Terpopuler'"></h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1"
                        x-text="searchQuery ? 'Ditemukan ' + filteredBooks.length + ' buku' : 'Daftar buku dengan rating tertinggi minggu ini'">
                    </p>
                </div>
                <i class="fas fa-fire text-amber-500 animate-pulse text-lg" x-show="!searchQuery"></i>
            </div>

            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                <template x-for="book in filteredBooks" :key="book.id">
                    <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1"
                                    :class="{
                                        'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': book.id %
                                            4 === 0,
                                        'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400': book
                                            .id % 4 === 1,
                                        'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400': book
                                            .id % 4 === 2,
                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400': book
                                            .id % 4 === 3
                                    }">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                        <span class="font-semibold"
                                            x-text="book.name"></span>
                                    </p>
                                    <div
                                        class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                        <span
                                            class="px-2 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 font-medium"
                                            x-text="book.category"></span>
                                        <span class="flex items-center gap-1">
                                            <span class="font-bold text-neutral-700 dark:text-neutral-300"></span>
                                            <span class="font-semibold"
                                            x-text="book.author"></span>
                                        </span>
                                        <span>•</span>
                                        <span class="font-bold"
                                            :class="book.stock > 0 ? 'text-green-600 dark:text-green-400' :
                                                'text-red-600 dark:text-red-400'"
                                            x-text="book.stock > 0 ? 'Tersedia (' + book.stock + ')' : 'Tidak Tersedia'">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 self-end sm:self-center">
                                <button @click="tambahKeKeranjang(book)"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-neutral-200 dark:disabled:bg-neutral-700 disabled:text-neutral-400 dark:disabled:text-neutral-500 text-white text-sm font-semibold rounded-lg transition-colors flex-shrink-0"
                                    :disabled="book.stock <= 0">
                                    Masukkan Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div x-show="filteredBooks.length === 0" class="p-16 text-center">
                    <i class="fas fa-search text-5xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                    <p class="text-neutral-600 dark:text-neutral-400 text-lg font-semibold">Buku tidak ditemukan</p>
                    <p class="text-neutral-500 text-sm mt-1">Coba cari dengan kata kunci lain atau pilih kategori yang
                        berbeda.</p>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            const booksData = {!! json_encode($books) !!};

            Alpine.data('catalogSetup', () => ({
                searchQuery: '',
                activeCategory: 'Semua',

                books: booksData.map(book => ({
                    id: book.id,
                    name: book.name,
                    category: book.category,
                    stock: book.stock,
                    status: book.status,
                    author: book.author || "Tidak Diketahui",
                    rating: (4.0 + ((book.id % 10) / 10)).toFixed(1),
                    coverColor: ['from-emerald-500 to-teal-700',
                        'from-blue-500 to-indigo-700', 'from-purple-500 to-pink-700',
                        'from-amber-500 to-orange-700'
                    ][book.id % 4]
                })),

                cart: JSON.parse(localStorage.getItem('fourbooks_cart') || '[]'),
                notification: {
                    show: false,
                    message: '',
                    type: 'success'
                },

                showNotification(msg, type = 'success') {
                    this.notification.message = msg;
                    this.notification.type = type;
                    this.notification.show = true;
                    setTimeout(() => {
                        this.notification.show = false;
                    }, 3000);
                },

                // LOGIKA KERANJANG DIKEMBALIKAN (Tanpa AJAX Fetch)
                tambahKeKeranjang(book) {
                    if (book.stock <= 0) {
                        this.showNotification('Stok buku sedang tidak tersedia!', 'error');
                        return;
                    }

                    // Cek jika buku sudah ada di dalam cart
                    if (this.cart.some(item => item.id === book.id)) {
                        this.showNotification('Buku ini sudah ada di keranjang Anda!', 'warning');
                        return;
                    }

                    // Push buku ke array cart
                    this.cart.push(book);
                    
                    // Simpan array cart yang baru ke LocalStorage browser
                    localStorage.setItem('fourbooks_cart', JSON.stringify(this.cart));
                    
                    // Trigger event untuk memperbarui ikon badge cart di navbar (opsional)
                    window.dispatchEvent(new CustomEvent('cart-updated'));

                    // Tampilkan notifikasi berhasil
                    this.showNotification(`Buku '${book.name}' dimasukkan ke keranjang!`, 'success');
                },

                get categories() {
                    const list = ['Semua'];
                    this.books.forEach(b => {
                        if (!list.includes(b.category)) list.push(b.category);
                    });
                    return list;
                },

                get filteredBooks() {
                    let filtered = this.books;
                    if (this.activeCategory !== 'Semua') {
                        filtered = filtered.filter(b => b.category === this.activeCategory);
                    }
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(b =>
                            b.name.toLowerCase().includes(query) ||
                            b.category.toLowerCase().includes(query) ||
                            b.author.toLowerCase().includes(query)
                        );
                    }
                    return filtered;
                }
            }));
        });
    </script>
</x-layouts::main>