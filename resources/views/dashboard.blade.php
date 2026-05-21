<x-layouts::main :title="__('Fourbooks')">
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Dashboard</h1>
        <p class="text-neutral-600 dark:text-neutral-400 mt-2">Ringkasan Toko Anda</p>
    </div>

    <!-- Top Stats Row - Orders for Today -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Pesanan Hari Ini 1 -->
        <x-stat-card
            icon="fas fa-shopping-cart"
            number="0"
            label="Pesanan Hari ini"
            bgColor="bg-sky-100"
            iconColor="text-sky-500"
        />

        <!-- Pesanan Hari Ini 2 -->
        <x-stat-card
            icon="fas fa-shopping-cart"
            number="0"
            label="Pesanan Hari ini"
            bgColor="bg-sky-100"
            iconColor="text-sky-500"
        />

        <!-- Pesanan Hari Ini 3 -->
        <x-stat-card
            icon="fas fa-shopping-cart"
            number="0"
            label="Pesanan Hari ini"
            bgColor="bg-sky-100"
            iconColor="text-sky-500"
        />
    </div>

    <!-- Product Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Produk - Yellow -->
        <x-product-stat-card
            icon="fas fa-cube"
            number="67"
            label="Total Produk"
            bgColor="bg-yellow-50 dark:bg-yellow-900/20"
            iconColor="text-yellow-600"
        />

        <!-- Total Produk - Orange -->
        <x-product-stat-card
            icon="fas fa-cube"
            number="67"
            label="Total Produk"
            bgColor="bg-orange-50 dark:bg-orange-900/20"
            iconColor="text-orange-600"
        />

        <!-- Total Produk - Pink -->
        <x-product-stat-card
            icon="fas fa-cube"
            number="67"
            label="Total Produk"
            bgColor="bg-pink-50 dark:bg-pink-900/20"
            iconColor="text-pink-600"
        />
    </div>



    <!-- Additional Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activities -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-plus text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">Produk Baru Ditambahkan</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">2 jam yang lalu</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between pb-3 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">Pesanan Selesai</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">5 jam yang lalu</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">Stok Menipis</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">1 hari yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Ringkasan Cepat</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-warehouse text-neutral-400"></i>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Total Kategori</span>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">12</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-neutral-400"></i>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Pesanan Bulan Ini</span>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">45</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-coins text-neutral-400"></i>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Penjualan Bulan Ini</span>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">Rp 2.5M</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-users text-neutral-400"></i>
                        <span class="text-sm text-neutral-600 dark:text-neutral-400">Total Pelanggan</span>
                    </div>
                    <span class="font-semibold text-neutral-900 dark:text-white">128</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts::main>
