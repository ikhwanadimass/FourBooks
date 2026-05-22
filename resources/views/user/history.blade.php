<x-layouts::main :title="__('Fourbooks - Riwayat Peminjaman')">
    <div x-data="historySetup" class="relative">

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

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-white">Riwayat Peminjaman
                    Saya</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2">Pantau status pengajuan, buku yang sedang aktif,
                    dan riwayat selesai dibaca Anda.</p>
            </div>
            <div class="relative w-full md:max-w-md">
                <input type="text" x-model="searchQuery" placeholder="Cari Riwayat berdasarkan Judul, Kategori..."
                    class="w-full px-5 py-3 pl-12 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-neutral-900 dark:text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <i class="fas fa-search absolute left-4 top-4 text-neutral-400"></i>
            </div>
        </div>

        <div
            class="flex flex-wrap items-center gap-2 mb-8 bg-neutral-100 dark:bg-neutral-800 p-1.5 rounded-2xl max-w-max border border-neutral-200/55 dark:border-neutral-700/50">
            <button @click="activeTab = 'semua'" class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                :class="activeTab === 'semua' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' :
                    'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'">
                Semua
            </button>
            <button @click="activeTab = 'dipinjam'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'dipinjam' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' :
                    'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                Sedang Dipinjam
            </button>
            <button @click="activeTab = 'diajukan'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'diajukan' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' :
                    'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'">
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
                Daftar Pengajuan
            </button>
            <button @click="activeTab = 'selesai'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'selesai' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' :
                    'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'">
                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                Selesai Pinjam
            </button>
            <button @click="activeTab = 'terlambat'"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center gap-1.5"
                :class="activeTab === 'terlambat' ? 'bg-white dark:bg-neutral-700 text-blue-600 dark:text-blue-400 shadow-md' :
                    'text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-200'">
                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                Denda / Terlambat
            </button>
        </div>

        <div
            class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl overflow-hidden border border-neutral-100 dark:border-neutral-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-neutral-50 dark:bg-neutral-700/50 border-b border-neutral-100 dark:border-neutral-700">
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Buku</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Tanggal Pinjam
                            </th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm">Batas
                                Pengembalian</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-center">
                                Status</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-right">
                                Denda</th>
                            <th class="p-5 font-extrabold text-neutral-800 dark:text-neutral-200 text-sm text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700/60">
                        <template x-for="item in filteredHistory" :key="item.id">
                            <tr class="hover:bg-neutral-50/50 dark:hover:bg-neutral-700/30 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 mt-1"
                                            :class="{
                                                'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400': item
                                                    .id % 4 === 0,
                                                'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400': item
                                                    .id % 4 === 1,
                                                'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400': item
                                                    .id % 4 === 2,
                                                'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400': item
                                                    .id % 4 === 3
                                            }">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-neutral-900 dark:text-white text-sm"
                                                x-text="item.name"></h4>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5"
                                                x-text="'Penulis: ' + item.author"></p>
                                            <span
                                                class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-300 font-semibold"
                                                x-text="item.category"></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-neutral-700 dark:text-neutral-300 font-medium"
                                    x-text="item.borrowDate"></td>
                                <td class="p-5 text-sm text-neutral-700 dark:text-neutral-300 font-medium"
                                    x-text="item.dueDate"></td>
                                <td class="p-5 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold shadow-sm"
                                        :class="{
                                            'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400': item
                                                .status === 'Dipinjam',
                                            'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400': item
                                                .status === 'Diajukan',
                                            'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400': item
                                                .status === 'Selesai',
                                            'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 animate-pulse': item
                                                .status === 'Terlambat'
                                        }">
                                        <i class="fas"
                                            :class="{
                                                'fa-book-reader': item.status === 'Dipinjam',
                                                'fa-clock': item.status === 'Diajukan',
                                                'fa-check-circle': item.status === 'Selesai',
                                                'fa-exclamation-circle': item.status === 'Terlambat'
                                            }"></i>
                                        <span x-text="item.status"></span>
                                    </span>
                                </td>
                                <td class="p-5 text-right font-bold text-sm"
                                    :class="item.fine > 0 ? 'text-red-500' : 'text-neutral-500 dark:text-neutral-400'">
                                    <span
                                        x-text="item.fine > 0 ? 'Rp ' + item.fine.toLocaleString('id-ID') : '-'"></span>
                                </td>
                                <td class="p-5 text-center">
                                    <button x-show="item.status === 'Dipinjam'" @click="kembalikanBuku(item)"
                                        class="px-4 py-1.5 bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow transition-colors active:scale-95">
                                        Kembalikan
                                    </button>
                                    <button x-show="item.status === 'Terlambat' && item.fine > 0"
                                        @click="openPayModal(item)"
                                        class="px-4 py-1.5 bg-red-500 hover:bg-red-600 text-white font-bold text-xs rounded-xl shadow-md transition-colors active:scale-95 animate-bounce">
                                        Bayar Denda
                                    </button>
                                    <span x-show="item.status === 'Diajukan'"
                                        class="text-xs text-neutral-400 italic">Menunggu Staff</span>
                                    <span x-show="item.status === 'Selesai'"
                                        class="text-xs text-green-500 font-bold flex items-center justify-center gap-1">
                                        <i class="fas fa-check"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredHistory.length === 0">
                            <td colspan="6" class="p-12 text-center">
                                <i class="fas fa-history text-5xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                                <p class="text-neutral-600 dark:text-neutral-400 text-lg font-semibold">Tidak ada
                                    riwayat peminjaman</p>
                                <p class="text-neutral-500 text-sm mt-1">Anda tidak memiliki catatan peminjaman dalam
                                    kategori ini.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="showPaymentModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            style="display: none;" x-transition>
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-neutral-100 dark:border-neutral-700"
                @click.outside="showPaymentModal = false">
                <div
                    class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700 flex items-center justify-between bg-neutral-50 dark:bg-neutral-700/50">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-wallet text-red-500"></i>
                        <span>Pelunasan Denda</span>
                    </h3>
                    <button @click="showPaymentModal = false"
                        class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div
                        class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 p-4 rounded-xl">
                        <p class="text-xs text-red-700 dark:text-red-400 font-semibold uppercase tracking-wider">Detail
                            Denda</p>
                        <h4 class="font-bold text-neutral-900 dark:text-white mt-1 text-base"
                            x-text="selectedFineItem?.name"></h4>
                        <div
                            class="flex justify-between items-center mt-3 pt-3 border-t border-red-100 dark:border-red-900/20">
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">Total Harus Dibayar</span>
                            <span class="text-lg font-extrabold text-red-600 dark:text-red-400"
                                x-text="selectedFineItem ? 'Rp ' + selectedFineItem.fine.toLocaleString('id-ID') : ''"></span>
                        </div>
                    </div>

                  
                </div>

                <div
                    class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/40 border-t border-neutral-100 dark:border-neutral-700 flex justify-end gap-3">
                    <button @click="showPaymentModal = false"
                        class="px-4 py-2 text-sm font-bold text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-xl transition-all"
                        :disabled="isPaying">
                        Batal
                    </button>
                    <button @click="bayarDenda()"
                        class="px-5 py-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-extrabold text-sm rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2"
                        :disabled="isPaying">
                        <i class="fas fa-spinner animate-spin" x-show="isPaying" style="display: none;"></i>
                        <span x-text="isPaying ? 'Memproses...' : 'Bayar Sekarang'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            const dbLoans = @json($loans ?? []);

            Alpine.data('historySetup', () => ({
                activeTab: 'semua',
                searchQuery: '',

                // Menerjemahkan data database agar sesuai dengan format UI
                history: dbLoans.map(loan => {
                    let currentStatus = '';
                    if (loan.status === 'pending') {
                        currentStatus = 'Diajukan';
                    } else if (loan.status === 'returned') {
                        currentStatus = 'Selesai';
                    } else if (loan.status === 'borrowed') {
                        currentStatus = loan.is_overdue ? 'Terlambat' : 'Dipinjam';
                    }

                    return {
                        id: loan.id,
                        name: loan.book ? loan.book.name : 'Buku Tidak Diketahui',
                        category: loan.book ? loan.book.category : '-',
                        author: loan.book ? loan.book.author : '-',
                        borrowDate: loan.loan_date || '-',
                        dueDate: loan.due_date || '-',
                        status: currentStatus,
                        fine: loan.calculated_fine_value || 0
                    };
                }),

                showPaymentModal: false,
                selectedFineItem: null,
                paymentMethod: 'gopay',
                isPaying: false,
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

                // KEMBALIKAN BUKU KE DATABASE
                async kembalikanBuku(item) {
                    if (confirm(`Apakah Anda yakin ingin mengembalikan buku '${item.name}'?`)) {
                        try {
                            let response = await fetch(`/user/loans/${item.id}/return`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });

                            if (response.ok) {
                                const found = this.history.find(h => h.id === item.id);
                                if (found) found.status = 'Selesai';
                                this.showNotification(`Buku '${item.name}' berhasil dikembalikan!`,
                                    'success');
                            } else {
                                this.showNotification('Gagal mengembalikan buku.', 'error');
                            }
                        } catch (error) {
                            this.showNotification('Terjadi kesalahan koneksi.', 'error');
                        }
                    }
                },

                openPayModal(item) {
                    this.selectedFineItem = item;
                    this.showPaymentModal = true;
                },

                // BAYAR DENDA KE DATABASE
                async bayarDenda() {
                    if (!this.selectedFineItem) return;
                    this.isPaying = true;
                    
                    try {
                        // 1. Minta Snap Token ke Controller
                        let response = await fetch(`/user/loans/${this.selectedFineItem.id}/pay`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        let result = await response.json();

                        if (response.ok && result.snap_token) {
                            // Tutup modal pilihan metode bayar lokal
                            this.showPaymentModal = false; 

                            // 2. Tampilkan Pop-up Midtrans Snap
                            window.snap.pay(result.snap_token, {
                                onSuccess: (paymentResult) => {
                                    // Callback jika user berhasil membayar
                                    const found = this.history.find(h => h.id === this.selectedFineItem.id);
                                    if (found) {
                                        found.status = 'Selesai';
                                        found.fine = 0;
                                        this.showNotification(`Denda untuk '${found.name}' berhasil dilunasi!`, 'success');
                                    }
                                    this.selectedFineItem = null;
                                },
                                onPending: (paymentResult) => {
                                    this.showNotification('Menunggu pembayaran diselesaikan...', 'warning');
                                },
                                onError: (paymentResult) => {
                                    this.showNotification('Pembayaran gagal.', 'error');
                                },
                                onClose: () => {
                                    this.showNotification('Anda menutup jendela pembayaran.', 'warning');
                                }
                            });
                        } else {
                            this.showNotification(result.message || 'Gagal mendapatkan token pembayaran.', 'error');
                        }
                    } catch (error) {
                        this.showNotification('Terjadi kesalahan saat menghubungi server.', 'error');
                    } finally {
                        this.isPaying = false;
                    }
                },

                get filteredHistory() {
                    let filtered = this.history;

                    // Filter berdasarkan Tab
                    if (this.activeTab !== 'semua') {
                        const tabMap = {
                            'dipinjam': 'Dipinjam',
                            'diajukan': 'Diajukan',
                            'selesai': 'Selesai',
                            'terlambat': 'Terlambat'
                        };
                        filtered = filtered.filter(h => h.status === tabMap[this.activeTab]);
                    }

                    // Filter berdasarkan Pencarian
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
            }));
        });
    </script>
</x-layouts::main>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
