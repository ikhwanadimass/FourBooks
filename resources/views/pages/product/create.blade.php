<x-layouts::main :title="__('Tambah Produk')">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 mb-4">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Tambah Produk Baru</h1>
        <p class="text-neutral-600 dark:text-neutral-400 mt-2">Masukkan informasi produk yang ingin Anda tambahkan</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Masukkan nama produk"
                    class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="category" 
                    name="category"
                    value="{{ old('category') }}"
                    required
                    placeholder="Contoh: Buku Novel, Buku Anak-anak"
                    class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                />
                @error('category')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="price" 
                    name="price"
                    value="{{ old('price') }}"
                    required
                    step="1000"
                    min="0"
                    placeholder="0"
                    class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                />
                @error('price')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Stok <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="stock" 
                    name="stock"
                    value="{{ old('stock') }}"
                    required
                    min="0"
                    placeholder="0"
                    class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                />
                @error('stock')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status" 
                    name="status"
                    required
                    class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                >
                    <option value="">-- Pilih Status --</option>
                    <option value="Aktif" @selected(old('status') === 'Aktif')>Aktif</option>
                    <option value="Nonaktif" @selected(old('status') === 'Nonaktif')>Nonaktif</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                <a 
                    href="{{ route('products.index') }}"
                    class="flex-1 px-6 py-3 text-center bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors"
                >
                    Batal
                </a>
                <button 
                    type="submit"
                    class="flex-1 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors shadow-md"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</x-layouts::main>
