<x-layouts::main :title="__('Daftar Peminjaman')">
    <div>
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Daftar Peminjaman</h1>
                <p class="text-neutral-600 dark:text-neutral-400 mt-2">Lihat semua transaksi pinjaman buku</p>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead>
                        <tr class="bg-neutral-50 dark:bg-neutral-700 border-b border-neutral-200 dark:border-neutral-600">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Pengguna</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Buku</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Tanggal Pinjam</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Due Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Tanggal Kembali</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-neutral-700 dark:text-neutral-300">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-600">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-neutral-900 dark:text-white">{{ $loan->id }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">{{ $loan->user->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">{{ $loan->book->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">{{ $loan->loan_date ? \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $loan->status === 'returned' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : ($loan->status === 'borrowed' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400') }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-neutral-900 dark:text-white">{{ 'Rp ' . number_format($loan->calculated_fine, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-book-reader text-4xl text-neutral-300 dark:text-neutral-600 mb-4"></i>
                                        <p class="text-neutral-600 dark:text-neutral-400 text-lg">Belum ada transaksi pinjaman</p>
                                        <p class="text-neutral-500 dark:text-neutral-500 text-sm mt-1">Semua peminjaman akan ditampilkan di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::main>
