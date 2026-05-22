<x-layouts::main :title="__('Fourbooks - Keranjang Pinjam')">
    <div x-data="cartSetup" class="relative">

        <div 
            x-show="notification.show" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-4 right-4 z-50 flex items-center gap-3 w-full max-w-sm p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-2xl border-l-4"
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

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Daftar Pengajuan Pinjam</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">Periksa daftar buku yang ingin Anda ajukan untuk dipinjam.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-md overflow-hidden">
                    <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700 flex justify-between items-center bg-neutral-50 dark:bg-neutral-800">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Buku dalam Keranjang</h3>
                        <span class="text-xs px-2.5 py-1 rounded-full font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400" x-text="cart.length + ' Buku'"></span>
                    </div>

                    <div class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        <template x-for="item in cart" :key="item.id">
                            <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-neutral-50 dark:hover:bg-neutral-700/30 transition-colors">
                                <div class="flex items-center gap-4">
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
                                        <h4 class="font-bold text-neutral-900 dark:text-white text-base" x-text="item.name"></h4>
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5" x-text="'Penulis: ' + item.author"></p>
                                        <span class="inline-block mt-2 text-xs px-2 py-0.5 rounded-md font-semibold bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300" x-text="item.category"></span>
                                    </div>
                                </div>
                                <button 
                                    @click="removeBook(item.id)"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded-xl transition-all"
                                >
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </div>
                        </template>

                        <div x-show="cart.length === 0" class="p-12 text-center">
                            <i class="fas fa-shopping-basket text-5xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                            <p class="text-neutral-600 dark:text-neutral-400 text-lg font-semibold">Keranjang pinjam kosong</p>
                            <p class="text-neutral-500 text-sm mt-1 mb-6">Anda belum menambahkan buku apa pun untuk diajukan.</p>
                            <a 
                                href="{{ route('user.catalog') }}" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-colors shadow-md"
                            >
                                <i class="fas fa-search"></i> Jelajahi Katalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-md p-6 sticky top-24 border border-neutral-100 dark:border-neutral-700">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Ringkasan Pengajuan</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm text-neutral-600 dark:text-neutral-400">
                            <span>Total Pengajuan</span>
                            <span class="font-semibold text-neutral-800 dark:text-white" x-text="cart.length + ' Buku'"></span>
                        </div>
                        <div class="flex justify-between text-sm text-neutral-600 dark:text-neutral-400">
                            <span>Durasi Peminjaman</span>
                            <span class="font-semibold text-neutral-800 dark:text-white">7 Hari</span>
                        </div>
                        <div class="border-t border-neutral-100 dark:border-neutral-700 pt-4 space-y-2">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 flex items-start gap-1.5 leading-relaxed">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                Setelah mengajukan, silakan datang ke perpustakaan untuk mengambil buku fisik setelah pengajuan disetujui staff.
                            </p>
                        </div>
                        <button 
                            @click="kirimPengajuan()"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 disabled:from-neutral-300 disabled:to-neutral-400 dark:disabled:from-neutral-700 dark:disabled:to-neutral-800 disabled:text-neutral-500 text-white font-bold rounded-xl transition-all shadow-md active:scale-95"
                            :disabled="cart.length === 0 || isSubmitting"
                        >
                            <i class="fas fa-spinner animate-spin" x-show="isSubmitting" style="display: none;"></i>
                            <i class="fas fa-paper-plane" x-show="!isSubmitting"></i>
                            <span x-text="isSubmitting ? 'Mengirim...' : 'Kirim Pengajuan'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartSetup', () => ({
                cart: JSON.parse(localStorage.getItem('fourbooks_cart') || '[]'),
                isSubmitting: false,
                notification: { show: false, message: '', type: 'success' },

                showNotification(msg, type = 'success') {
                    this.notification.message = msg;
                    this.notification.type = type;
                    this.notification.show = true;
                    setTimeout(() => { this.notification.show = false; }, 3000);
                },

                removeBook(bookId) {
                    this.cart = this.cart.filter(item => item.id !== bookId);
                    localStorage.setItem('fourbooks_cart', JSON.stringify(this.cart));
                    window.dispatchEvent(new CustomEvent('cart-updated'));
                    this.showNotification('Buku berhasil dihapus dari daftar pengajuan.', 'success');
                },

                async kirimPengajuan() {
                    if (this.cart.length === 0) return;
                    this.isSubmitting = true;

                    let successCount = 0;
                    let errorMessages = [];

                    // Loop melalui setiap buku di keranjang untuk dikirim ke database
                    for (const book of this.cart) {
                        try {
                            let response = await fetch("{{ route('user.loans.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ book_id: book.id })
                            });

                            let result = await response.json();

                            if (response.ok) {
                                successCount++;
                            } else {
                                // Tampung pesan error (contoh: stok habis, sudah dipinjam)
                                errorMessages.push(`'${book.name}': ${result.message}`);
                            }
                        } catch (error) {
                            errorMessages.push(`'${book.name}': Gagal terhubung ke server.`);
                        }
                    }

                    this.isSubmitting = false;

                    // Jika ada setidaknya 1 buku yang berhasil masuk database
                    if (successCount > 0) {
                        // Kosongkan keranjang
                        this.cart = [];
                        localStorage.setItem('fourbooks_cart', '[]');
                        window.dispatchEvent(new CustomEvent('cart-updated'));

                        // Cek apakah ada buku yang gagal di-insert
                        if (errorMessages.length > 0) {
                            this.showNotification(`Sebagian terkirim. Gagal: ${errorMessages[0]}`, 'warning');
                        } else {
                            this.showNotification('Semua pengajuan peminjaman berhasil dikirim ke Admin!', 'success');
                        }
                    } else {
                        // Jika tidak ada satu pun buku yang berhasil di-insert
                        this.showNotification(`Gagal mengirim pengajuan: ${errorMessages[0]}`, 'error');
                    }
                }
            }));
        });
    </script>
</x-layouts::main>