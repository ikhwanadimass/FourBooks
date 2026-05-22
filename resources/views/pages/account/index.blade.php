<x-layouts::main :title="__('Akun')">
    <div x-data="{ openModal: false }">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Akun</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2">Atur Akun Mu</p>
            </div>
            <button 
                @click="openModal = true"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors shadow-md"
            >
                <i class="fas fa-plus text-lg"></i>
                Tambah Staff
            </button>
        </div>

        <!-- Accounts Table -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
            <!-- Table Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-neutral-50 dark:bg-neutral-700 border-b border-neutral-200 dark:border-neutral-600">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Deskripsi</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-neutral-700 dark:text-neutral-300">Aksi</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-600">
                        @forelse($accounts as $account)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-neutral-900 dark:text-white">{{ $account->name }}</p>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $account->email }}</p>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-neutral-700 dark:text-neutral-300">{{ $account->created_at->format('d M Y, H:i') }}</p>
                                </td>

                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold @if($account->role === 'staff') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @else bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 @endif">
                                        {{ ucfirst($account->role) }}
                                    </span>
                                </td>

                                <!-- Delete Action -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <form method="POST" action="{{ route('accounts.destroy', $account->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
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
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-users text-4xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                                        <p class="text-neutral-600 dark:text-neutral-400 text-lg">Belum ada akun staff</p>
                                        <p class="text-neutral-500 dark:text-neutral-500 text-sm mt-1">Mulai dengan menambahkan staff pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Overlay -->
        <div 
            x-show="openModal" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" 
            style="display: none;"
            @click="openModal = false"
        >
            <!-- Modal Content -->
            <div 
                @click.stop
                x-show="openModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg max-w-md w-full p-6"
            >
                <!-- Modal Header -->
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">Tambah Staff</h2>

                <!-- Modal Form -->
                <form method="POST" action="{{ route('accounts.store') }}" class="space-y-4">
                    @csrf

                    <!-- Section Title -->
                    <div>
                        <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-4">Masukan Data</p>
                    </div>

                    <!-- Name Input -->
                    <div>
                        <label for="modal-name" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            id="modal-name" 
                            name="name"
                            required
                            placeholder="Tere Liye bla bla"
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                        />
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="modal-email" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="modal-email" 
                            name="email"
                            required
                            placeholder="Tere Liye bla bla"
                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all"
                        />
                    </div>

                    <!-- Role Input (Hidden, default to staff) -->
                    <input type="hidden" name="role" value="staff">

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="button"
                            @click="openModal = false"
                            class="flex-1 px-4 py-2 text-center bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors"
                        >
                            Batal
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition-colors"
                        >
                            Tambah Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::main>
