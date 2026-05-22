<x-layouts::main :title="__('Fourbooks - Riwayat Peminjaman')">
    <div x-data="{
        activeTab: 'semua',
        searchQuery: '',
        history: JSON.parse(localStorage.getItem('fourbooks_history') || '[]'),
        
        // Modal states
        showPaymentModal: false,
        selectedFineItem: null,
        paymentMethod: 'gopay',
        isPaying: false,
        
        notification: { show: false, message: '', type: 'success' },

        init() {
            // Initialize mock data if history is empty
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
                this.history = mockHistory;
            }
        },

        showNotification(msg, type = 'success') {
            this.notification.message = msg;
            this.notification.type = type;
            this.notification.show = true;
            setTimeout(() => { this.notification.show = false; }, 3000);
        },

        saveHistoryState() {
            localStorage.setItem('fourbooks_history', JSON.stringify(this.history));
            
            // Re-sync values
            const borrowed = this.history.filter(h => h.status === 'Dipinjam').length;
            const completed = this.history.filter(h => h.status === 'Selesai').length;
            const totalFine = this.history.filter(h => h.status === 'Terlambat').reduce((sum, h) => sum + h.fine, 0);

            localStorage.setItem('fourbooks_borrowed_count', borrowed.toString());
            localStorage.setItem('fourbooks_completed_count', completed.toString());
            localStorage.setItem('fourbooks_fine_amount', totalFine.toString());

            // Sync global layouts
            window.dispatchEvent(new CustomEvent('cart-updated'));
        },

        kembalikanBuku(item) {
            if (confirm(`Apakah Anda yakin ingin mengembalikan buku '${item.name}'?`)) {
                const found = this.history.find(h => h.id === item.id);
                if (found) {
                    found.status = 'Selesai';
                    this.saveHistoryState();
                    this.showNotification(`Buku '${item.name}' berhasil dikembalikan!`, 'success');
                }
            }
        },

        openPayModal(item) {
            this.selectedFineItem = item;
            this.showPaymentModal = true;
        },

        bayarDenda() {
            if (!this.selectedFineItem) return;
            this.isPaying = true;
            
            setTimeout(() => {
                const found = this.history.find(h => h.id === this.selectedFineItem.id);
                if (found) {
                    found.status = 'Selesai';
                    found.fine = 0;
                    this.saveHistoryState();
                    this.showNotification(`Denda untuk '${found.name}' berhasil dilunasi!`, 'success');
                }
                this.isPaying = false;
                this.showPaymentModal = false;
                this.selectedFineItem = null;
            }, 1500);
        },

        get filteredHistory() {
            let filtered = this.history;
            
            // Filter by Tab
            if (this.activeTab !== 'semua') {
                const tabMap = {
                    'dipinjam': 'Dipinjam',
                    'diajukan': 'Diajukan',
                    'selesai': 'Selesai',
                    'terlambat': 'Terlambat'
                };
                filtered = filtered.filter(h => h.status === tabMap[this.activeTab]);
            }
            
            // Filter by Search Query
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(h => 
                    h.name.toLowerCase().includes(query) ||
                    h.category.toLowerCase().includes(query) ||
                    h.author.toLowerCase().includes(query)
                );
            }
            
            return filtered;
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

        <!-- Page Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-white">Riwayat Peminjaman Saya</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2">Pantau status pengajuan, buku yang sedang aktif, dan riwayat selesai dibaca Anda.</p>
            </div>
            <!-- Search Bar -->
            <div class="relative w-full md:max-w-md">
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari Riwayat berdasarkan Judul, Kategori..." 
                    class="w-full px-5 py-3 pl-12 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-neutral-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                >
                <i class="fas fa-search absolute left-4 top-4 text-neutral-400"></i>
            </div>
        </div>

        <!-- Tabs Filter -->
        <div class="flex flex-wrap items-center gap-2 mb-8 bg-neutral-100 dark:bg-neutral-800 p-1.5 rounded-2xl max-w-max border border-neutral-200/55 dark:border-neutral-700/50">
            <button 
                @click="activeTab = 'semua'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                :class="activeTab === 'semua' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'"
            >
                Semua
            </button>
            <button 
                @click="activeTab = 'dipinjam'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'dipinjam' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'"
            >
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                Sedang Dipinjam
            </button>
            <button 
                @click="activeTab = 'diajukan'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'diajukan' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'"
            >
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
                Daftar Pengajuan
            </button>
            <button 
                @click="activeTab = 'selesai'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'selesai' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'"
            >
                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                Selesai Pinjam
            </button>
            <button 
                @click="activeTab = 'terlambat'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'terlambat' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'"
            >
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                Denda / Terlambat
            </button>
        </div>

        <!-- History Display -->
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl overflow-hidden border border-neutral-100 dark:border-neutral-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-neutral-50 dark:bg-neutral-700/50 border-b border-neutral-100 dark:border-neutral-700">
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Buku</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Tanggal Pinjam</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Batas Pengembalian</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-center">Status</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-right">Denda</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700/60">
                        <template x-for="item in filteredHistory" :key="item.id">
                            <tr class="hover:bg-neutral-50/50 dark:hover:bg-neutral-700/30 transition-colors">
                                <!-- Book Details -->
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <!-- Category Icon Box -->
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1"
                                             :class="{
                                                 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': item.id % 4 === 0,
                                                 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400': item.id % 4 === 1,
                                                 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400': item.id % 4 === 2,
                                                 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400': item.id % 4 === 3
                                             }">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-neutral-900 dark:text-white text-sm" x-text="item.name"></h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5" x-text="'Penulis: ' + item.author"></p>
                                            <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-300 font-semibold" x-text="item.category"></span>
                                        </div>
                                    </div>
                                </td>
                                <!-- Dates -->
                                <td class="p-5 text-sm text-neutral-700 dark:text-neutral-300 font-medium" x-text="item.borrowDate || '-'"></td>
                                <td class="p-5 text-sm text-neutral-700 dark:text-neutral-300 font-medium" x-text="item.dueDate || '-'"></td>
                                <!-- Badge Status -->
                                <td class="p-5 text-center">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold shadow-sm"
                                        :class="{
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400': item.status === 'Dipinjam',
                                            'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400': item.status === 'Diajukan',
                                            'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400': item.status === 'Selesai',
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 animate-pulse': item.status === 'Terlambat'
                                        }"
                                    >
                                        <i class="fas" :class="{
                                            'fa-book-reader': item.status === 'Dipinjam',
                                            'fa-clock': item.status === 'Diajukan',
                                            'fa-check-circle': item.status === 'Selesai',
                                            'fa-exclamation-circle': item.status === 'Terlambat'
                                        }"></i>
                                        <span x-text="item.status"></span>
                                    </span>
                                </td>
                                <!-- Fine -->
                                <td class="p-5 text-right font-bold text-sm" :class="item.fine > 0 ? 'text-red-500' : 'text-neutral-500 dark:text-neutral-400'">
                                    <span x-text="item.fine > 0 ? 'Rp ' + item.fine.toLocaleString('id-ID') : '-'"></span>
                                </td>
                                <!-- Action Buttons -->
                                <td class="p-5 text-center">
                                    <!-- Kembalikan Buku -->
                                    <button 
                                        x-show="item.status === 'Dipinjam'"
                                        @click="kembalikanBuku(item)"
                                        class="px-4 py-1.5 bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow transition-colors active:scale-95"
                                    >
                                        Kembalikan
                                    </button>
                                    <!-- Bayar Denda -->
                                    <button 
                                        x-show="item.status === 'Terlambat' && item.fine > 0"
                                        @click="openPayModal(item)"
                                        class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white font-bold text-xs rounded-xl shadow-md transition-colors active:scale-95 animate-bounce"
                                    >
                                        Bayar Denda
                                    </button>
                                    <!-- No actions for Diajukan or Selesai -->
                                    <span x-show="item.status === 'Diajukan'" class="text-xs text-neutral-400 italic">Menunggu Staff</span>
                                    <span x-show="item.status === 'Selesai'" class="text-xs text-green-500 font-bold flex items-center justify-center gap-1">
                                        <i class="fas fa-check"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <tr x-show="filteredHistory.length === 0">
                            <td colspan="6" class="p-12 text-center">
                                <i class="fas fa-history text-5xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                                <p class="text-neutral-600 dark:text-neutral-400 text-lg font-semibold">Tidak ada riwayat peminjaman</p>
                                <p class="text-neutral-500 text-sm mt-1">Anda tidak memiliki catatan peminjaman dalam kategori ini.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pay Fine Modal (Glassmorphism & High End Design) -->
        <div 
            x-show="showPaymentModal" 
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            style="display: none;"
            x-transition
        >
            <div 
                class="bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-neutral-100 dark:border-neutral-700"
                @click.outside="showPaymentModal = false"
            >
                <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700 flex items-center justify-between bg-neutral-50 dark:bg-neutral-700/50">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-wallet text-red-500"></i>
                        <span>Pelunasan Denda</span>
                    </h3>
                    <button @click="showPaymentModal = false" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Fine Detail -->
                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 p-4 rounded-xl">
                        <p class="text-xs text-red-700 dark:text-red-400 font-semibold uppercase tracking-wider">Detail Denda</p>
                        <h4 class="font-bold text-neutral-900 dark:text-white mt-1 text-base" x-text="selectedFineItem?.name"></h4>
                        <div class="flex justify-between items-center mt-3 pt-3 border-t border-red-100 dark:border-red-900/20">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Total Harus Dibayar</span>
                            <span class="text-lg font-extrabold text-red-600 dark:text-red-400" x-text="selectedFineItem ? 'Rp ' + selectedFineItem.fine.toLocaleString('id-ID') : ''"></span>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div>
                        <span class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-3">Pilih Metode Pembayaran</span>
                        <div class="grid grid-cols-2 gap-3">
                            <!-- GoPay -->
                            <label 
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all active:scale-95"
                                :class="paymentMethod === 'gopay' ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-900/10' : 'border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'"
                            >
                                <input type="radio" x-model="paymentMethod" value="gopay" class="hidden">
                                <i class="fab fa-google text-blue-500 text-lg"></i>
                                <span class="text-sm font-bold text-neutral-800 dark:text-white">GoPay</span>
                            </label>
                            <!-- OVO -->
                            <label 
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all active:scale-95"
                                :class="paymentMethod === 'ovo' ? 'border-purple-500 bg-purple-50/30 dark:bg-purple-900/10' : 'border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'"
                            >
                                <input type="radio" x-model="paymentMethod" value="ovo" class="hidden">
                                <i class="fas fa-coins text-purple-500 text-lg"></i>
                                <span class="text-sm font-bold text-neutral-800 dark:text-white">OVO</span>
                            </label>
                            <!-- ShopeePay -->
                            <label 
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all active:scale-95"
                                :class="paymentMethod === 'shopeepay' ? 'border-orange-500 bg-orange-50/30 dark:bg-orange-900/10' : 'border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'"
                            >
                                <input type="radio" x-model="paymentMethod" value="shopeepay" class="hidden">
                                <i class="fas fa-shopping-bag text-orange-500 text-lg"></i>
                                <span class="text-sm font-bold text-neutral-800 dark:text-white">ShopeePay</span>
                            </label>
                            <!-- Bank Transfer -->
                            <label 
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all active:scale-95"
                                :class="paymentMethod === 'bank' ? 'border-emerald-500 bg-emerald-50/30 dark:bg-emerald-900/10' : 'border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700/50'"
                            >
                                <input type="radio" x-model="paymentMethod" value="bank" class="hidden">
                                <i class="fas fa-university text-emerald-500 text-lg"></i>
                                <span class="text-sm font-bold text-neutral-800 dark:text-white">Transfer</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/40 border-t border-neutral-100 dark:border-neutral-700 flex justify-end gap-3">
                    <button 
                        @click="showPaymentModal = false"
                        class="px-4 py-2 text-sm font-bold text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-xl transition-all"
                        :disabled="isPaying"
                    >
                        Batal
                    </button>
                    <button 
                        @click="bayarDenda()"
                        class="px-5 py-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-extrabold text-sm rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2"
                        :disabled="isPaying"
                    >
                        <i class="fas fa-spinner animate-spin" x-show="isPaying"></i>
                        <span x-text="isPaying ? 'Memproses...' : 'Bayar Sekarang'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-layouts::main>
