<x-layouts::main :title="__('Fourbooks - Anggota')">
    <div x-data="{
        searchQuery: '',
        books: [
            @foreach($products as $book)
            {
                id: {{ $book->id }},
                name: '{{ addslashes($book->name) }}',
                category: '{{ addslashes($book->category) }}',
                price: {{ $book->price }},
                stock: {{ $book->stock }},
                status: '{{ $book->status }}',
                author: '{{ ['Tere Liye', 'Fiersa Besari', 'Dee Lestari', 'Habiburrahman El Shirazy'][($book->id % 4)] }}',
                rating: {{ number_format(4.0 + (($book->id % 10) / 10), 1) }},
                coverColor: '{{ ['from-emerald-500 to-teal-700', 'from-blue-500 to-indigo-700', 'from-purple-500 to-pink-700', 'from-amber-500 to-orange-700'][($book->id % 4)] }}'
            },
            @endforeach
        ],
        cart: JSON.parse(localStorage.getItem('fourbooks_cart') || '[]'),
        history: [],
        borrowedCount: 3,
        completedCount: 12,
        fineAmount: 15000,
        notification: { show: false, message: '', type: 'success' },

        init() {
            // Initialize mock history if empty
            if (!localStorage.getItem('fourbooks_history') || JSON.parse(localStorage.getItem('fourbooks_history')).length === 0) {
                const mockHistory = [
                    {
                        id: 101,
                        name: 'Bumi',
                        category: 'Novel',
                        author: 'Tere Liye',
                        coverColor: 'from-emerald-500 to-teal-700',
                        borrowDate: new Date(Date.now() - 5 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        dueDate: new Date(Date.now() + 2 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        status: 'Dipinjam',
                        fine: 0
                    },
                    {
                        id: 102,
                        name: 'Pulang',
                        category: 'Novel',
                        author: 'Tere Liye',
                        coverColor: 'from-blue-500 to-indigo-700',
                        borrowDate: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        dueDate: new Date(Date.now() + 4 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        status: 'Dipinjam',
                        fine: 0
                    },
                    {
                        id: 103,
                        name: 'Garis Waktu',
                        category: 'Fiksi',
                        author: 'Fiersa Besari',
                        coverColor: 'from-purple-500 to-pink-700',
                        borrowDate: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        dueDate: new Date(Date.now() + 6 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        status: 'Dipinjam',
                        fine: 0
                    },
                    {
                        id: 104,
                        name: 'Supernova',
                        category: 'Fiksi',
                        author: 'Dee Lestari',
                        coverColor: 'from-amber-500 to-orange-700',
                        borrowDate: new Date(Date.now() - 15 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        dueDate: new Date(Date.now() - 8 * 24 * 60 * 60 * 1000).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }),
                        status: 'Terlambat',
                        fine: 15000
                    },
                    { id: 201, name: 'Hujan', category: 'Novel', author: 'Tere Liye', coverColor: 'from-emerald-500 to-teal-700', borrowDate: '01 April 2026', dueDate: '08 April 2026', status: 'Selesai', fine: 0 },
                    { id: 202, name: 'Konspirasi Alam Semesta', category: 'Fiksi', author: 'Fiersa Besari', coverColor: 'from-blue-500 to-indigo-700', borrowDate: '05 April 2026', dueDate: '12 April 2026', status: 'Selesai', fine: 0 },
                    { id: 203, name: 'Filosofi Kopi', category: 'Kumpulan Cerpen', author: 'Dee Lestari', coverColor: 'from-purple-500 to-pink-700', borrowDate: '10 April 2026', dueDate: '17 April 2026', status: 'Selesai', fine: 0 },
                    { id: 204, name: 'Ayat-Ayat Cinta', category: 'Religi', author: 'Habiburrahman El Shirazy', coverColor: 'from-amber-500 to-orange-700', borrowDate: '15 April 2026', dueDate: '22 April 2026', status: 'Selesai', fine: 0 },
                    { id: 205, name: 'Perahu Kertas', category: 'Novel', author: 'Dee Lestari', coverColor: 'from-emerald-500 to-teal-700', borrowDate: '20 April 2026', dueDate: '27 April 2026', status: 'Selesai', fine: 0 },
                    { id: 206, name: 'Komet', category: 'Novel', author: 'Tere Liye', coverColor: 'from-blue-500 to-indigo-700', borrowDate: '25 April 2026', dueDate: '02 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 207, name: 'Catatan Juang', category: 'Fiksi', author: 'Fiersa Besari', coverColor: 'from-purple-500 to-pink-700', borrowDate: '28 April 2026', dueDate: '05 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 208, name: 'Mata Hari', category: 'Novel', author: 'Tere Liye', coverColor: 'from-amber-500 to-orange-700', borrowDate: '01 Mei 2026', dueDate: '08 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 209, name: 'Aroma Karsa', category: 'Novel', author: 'Dee Lestari', coverColor: 'from-emerald-500 to-teal-700', borrowDate: '03 Mei 2026', dueDate: '10 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 210, name: 'Bumi Manusia', category: 'Sejarah', author: 'Pramoedya Ananta Toer', coverColor: 'from-blue-500 to-indigo-700', borrowDate: '05 Mei 2026', dueDate: '12 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 211, name: 'Anak Semua Bangsa', category: 'Sejarah', author: 'Pramoedya Ananta Toer', coverColor: 'from-purple-500 to-pink-700', borrowDate: '08 Mei 2026', dueDate: '15 Mei 2026', status: 'Selesai', fine: 0 },
                    { id: 212, name: 'Jejak Langkah', category: 'Sejarah', author: 'Pramoedya Ananta Toer', coverColor: 'from-amber-500 to-orange-700', borrowDate: '10 Mei 2026', dueDate: '17 Mei 2026', status: 'Selesai', fine: 0 }
                ];
                localStorage.setItem('fourbooks_history', JSON.stringify(mockHistory));
                localStorage.setItem('fourbooks_borrowed_count', '3');
                localStorage.setItem('fourbooks_completed_count', '12');
                localStorage.setItem('fourbooks_fine_amount', '15000');
            }
            this.syncState();
            
            // Sync on update
            window.addEventListener('cart-updated', () => this.syncState());
        },

        syncState() {
            this.history = JSON.parse(localStorage.getItem('fourbooks_history') || '[]');
            this.borrowedCount = this.history.filter(h => h.status === 'Dipinjam').length;
            this.completedCount = this.history.filter(h => h.status === 'Selesai').length;
            this.fineAmount = this.history.filter(h => h.status === 'Terlambat').reduce((sum, h) => sum + h.fine, 0);
        },
        
        showNotification(msg, type = 'success') {
            this.notification.message = msg;
            this.notification.type = type;
            this.notification.show = true;
            setTimeout(() => { this.notification.show = false; }, 3000);
        },

        ajukanPinjam(book) {
            if (book.stock <= 0) {
                this.showNotification('Stok buku sedang tidak tersedia!', 'error');
                return;
            }

            // Check if already in cart or borrowed
            if (this.cart.some(item => item.id === book.id)) {
                this.showNotification('Buku ini sudah ada di daftar pengajuan Anda!', 'warning');
                return;
            }

            this.cart.push(book);
            localStorage.setItem('fourbooks_cart', JSON.stringify(this.cart));
            
            // Dispatch dynamic event to update layouts if needed
            window.dispatchEvent(new CustomEvent('cart-updated'));

            this.showNotification(`Berhasil mengajukan peminjaman untuk '${book.name}'!`, 'success');
        },

        get filteredBooks() {
            if (!this.searchQuery) return this.books;
            const query = this.searchQuery.toLowerCase();
            return this.books.filter(b => 
                b.name.toLowerCase().includes(query) || 
                b.category.toLowerCase().includes(query) ||
                b.author.toLowerCase().includes(query)
            );
        }
    }" class="relative">

        <!-- Toast Notification -->
        <div 
            x-show="notification.show" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-4 right-4 z-50 flex items-center gap-3 w-full max-w-sm p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-2xl border-l-4 border-blue-500"
            style="display: none;"
            :class="{
                'border-green-500': notification.type === 'success',
                'border-yellow-500': notification.type === 'warning',
                'border-red-500': notification.type === 'error'
            }"
        >
            <div class="flex-1">
                <p class="text-sm font-semibold text-neutral-900 dark:text-white" x-text="notification.message"></p>
            </div>
            <button @click="notification.show = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Personal Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Dashboard</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2">Ringkasan Aktivitas Anda</p>
            </div>
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-md">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari Judul, Kategori, atau Penulis..." 
                    class="w-full px-5 py-3 pl-12 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-neutral-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                >
                <i class="fas fa-search absolute left-4 top-4 text-neutral-400"></i>
            </div>
        </div>

        <!-- Monitoring Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Buku Sedang Dipinjam -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Total Buku Dipinjam</p>
                            <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2" x-text="borrowedCount"></p>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-2">(Aktif)</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-reader text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Selesai Dibaca -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Total Selesai Dibaca</p>
                            <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2" x-text="completedCount"></p>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 mt-2">Keaktifan membaca Anda</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Tanggungan Denda -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden border-l-4 border-red-500">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm font-medium">Tanggungan Denda</p>
                            <p class="text-3xl font-bold text-neutral-900 dark:text-white mt-2" x-text="fineAmount > 0 ? 'Rp ' + fineAmount.toLocaleString('id-ID') : 'Rp 0'"></p>
                            <p class="text-xs mt-2" :class="fineAmount > 0 ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-neutral-600 dark:text-neutral-400'" x-text="fineAmount > 0 ? 'Segera lakukan pelunasan' : 'Bebas dari denda'"></p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Komponen Utama Halaman -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white" x-text="searchQuery ? 'Hasil Pencarian' : 'Rekomendasi Buku Terpopuler'"></h3>
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1" x-text="searchQuery ? 'Ditemukan ' + filteredBooks.length + ' buku' : 'Daftar buku dengan rating tertinggi minggu ini'"></p>
                </div>
                <i class="fas fa-fire text-amber-500 animate-pulse text-lg" x-show="!searchQuery"></i>
            </div>

            <!-- List Container -->
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                <template x-for="book in filteredBooks" :key="book.id">
                    <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Category Icon Box -->
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1"
                                     :class="{
                                         'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': book.id % 4 === 0,
                                         'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400': book.id % 4 === 1,
                                         'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400': book.id % 4 === 2,
                                         'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400': book.id % 4 === 3
                                     }">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">
                                        Rekomendasi buku <span class="font-semibold" x-text="'\'' + book.name + '\''"></span> oleh <span class="font-semibold" x-text="book.author"></span>
                                    </p>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                        <span class="px-2 py-0.5 rounded bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 font-medium" x-text="book.category"></span>
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-star text-amber-500"></i>
                                            <span class="font-bold text-neutral-700 dark:text-neutral-300" x-text="book.rating"></span>
                                            <span>(45 ulasan)</span>
                                        </span>
                                        <span>•</span>
                                        <span class="font-bold" 
                                              :class="book.stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                                              x-text="book.stock > 0 ? 'Tersedia (' + book.stock + ')' : 'Tidak Tersedia'">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Action button on the right -->
                            <div class="flex-shrink-0 self-end sm:self-center">
                                <button 
                                    @click="ajukanPinjam(book)"
                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 disabled:bg-neutral-200 dark:disabled:bg-neutral-700 disabled:text-neutral-400 dark:disabled:text-neutral-500 text-white text-sm font-semibold rounded-lg transition-colors flex-shrink-0"
                                    :disabled="book.stock <= 0"
                                >
                                    Ajukan Pinjam
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="filteredBooks.length === 0" class="p-16 text-center">
                    <i class="fas fa-search text-5xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                    <p class="text-neutral-600 dark:text-neutral-400 text-lg font-semibold">Buku tidak ditemukan</p>
                    <p class="text-neutral-500 text-sm mt-1">Coba cari dengan kata kunci lain atau periksa ejaan Anda.</p>
                </div>
            </div>
        </div>

    </div>
</x-layouts::main>
