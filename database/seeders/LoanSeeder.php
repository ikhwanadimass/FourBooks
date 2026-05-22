<?php

namespace Database\Seeders;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        $loans = [
            // Skenario 1: Buku ID 1 sedang dipinjam (Status: borrowed)
            [
                'user_id' => 3,
                'book_id' => 1,
                'loan_date' => Carbon::now()->subDays(2)->format('Y-m-d'), // Pinjam 2 hari yang lalu
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),  // Batas kembali 5 hari ke depan
                'return_date' => null,
                'fine' => 0,
                'status' => 'borrowed',
                'is_approved' => true,
                'is_return_confirmed' => false,
            ],
            // Skenario 2: Buku ID 2 terlambat dikembalikan (Status: Overdue)
            // Tetap berstatus 'borrowed' di database karena fisik buku belum kembali, tapi due_date sudah lewat
            [
                'user_id' => 3,
                'book_id' => 2,
                'loan_date' => Carbon::now()->subDays(10)->format('Y-m-d'), // Pinjam 10 hari yang lalu
                'due_date' => Carbon::now()->subDays(3)->format('Y-m-d'),  // Batas kembali harusnya 3 hari yang lalu
                'return_date' => null,
                'fine' => 15000, // Contoh denda akumulasi keterlambatan 3 hari (misal Rp 5.000/hari)
                'status' => 'borrowed',
                'is_approved' => true,
                'is_return_confirmed' => false,
            ],
            // Skenario 3: Buku ID 3 sudah dikembalikan tepat waktu (Status: returned)
            [
                'user_id' => 3,
                'book_id' => 3,
                'loan_date' => Carbon::now()->subDays(7)->format('Y-m-d'),   // Pinjam 7 hari yang lalu
                'due_date' => Carbon::now()->subDays(1)->format('Y-m-d'),   // Batas kembali 1 hari yang lalu
                'return_date' => Carbon::now()->subDays(2)->format('Y-m-d'), // Sudah dikembalikan 2 hari yang lalu (aman sebelum deadline)
                'fine' => 0,
                'status' => 'returned',
                'is_approved' => true,
                'is_return_confirmed' => true,
            ],
            // Skenario 4: Buku ID 4 baru diajukan dan belum disetujui Admin (Status: pending)
            [
                'user_id' => 3,
                'book_id' => 4,
                'loan_date' => Carbon::now()->format('Y-m-d'), // Hari ini
                'due_date' => Carbon::now()->addDays(7)->format('Y-m-d'), // Standar 7 hari ke depan
                'return_date' => null,
                'fine' => 0,
                'status' => 'pending', // Menunggu persetujuan admin
                'is_approved' => false,
                'is_return_confirmed' => false,
            ],
            // Skenario 5: Buku ID 5 sudah dikembalikan user tapi belum dikonfirmasi Admin (Status: returned, is_return_confirmed: false)
            [
                'user_id' => 3,
                'book_id' => 5,
                'loan_date' => Carbon::now()->subDays(6)->format('Y-m-d'),
                'due_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'return_date' => Carbon::now()->format('Y-m-d'), // Dikembalikan hari ini
                'fine' => 0,
                'status' => 'returned',
                'is_approved' => true,
                'is_return_confirmed' => false, // Admin belum klik konfirmasi
            ],
            [
                'user_id' => 4, 'book_id' => 6,
                'loan_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'due_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'return_date' => null, 'fine' => 0, 'status' => 'borrowed',
                'is_approved' => true, 'is_return_confirmed' => false,
            ],
            // 2. Dipinjam (Normal)
            [
                'user_id' => 4, 'book_id' => 7,
                'loan_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'return_date' => null, 'fine' => 0, 'status' => 'borrowed',
                'is_approved' => true, 'is_return_confirmed' => false,
            ],
            // 3. Selesai
            [
                'user_id' => 4, 'book_id' => 8,
                'loan_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'due_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'return_date' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'fine' => 0, 'status' => 'returned',
                'is_approved' => true, 'is_return_confirmed' => true,
            ],
            // 4. Selesai
            [
                'user_id' => 4, 'book_id' => 9,
                'loan_date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'due_date' => Carbon::now()->subDays(8)->format('Y-m-d'),
                'return_date' => Carbon::now()->subDays(8)->format('Y-m-d'),
                'fine' => 0, 'status' => 'returned',
                'is_approved' => true, 'is_return_confirmed' => true,
            ],
            // 5. TERLAMBAT (Overdue) - Denda 10.000
            [
                'user_id' => 4, 'book_id' => 10,
                'loan_date' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'due_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'return_date' => null, 'fine' => 10000, 'status' => 'borrowed',
                'is_approved' => true, 'is_return_confirmed' => false,
            ],
            // 6. TERLAMBAT (Overdue) - Denda 5.000
            [
                'user_id' => 4, 'book_id' => 11,
                'loan_date' => Carbon::now()->subDays(12)->format('Y-m-d'),
                'due_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'return_date' => null, 'fine' => 5000, 'status' => 'borrowed',
                'is_approved' => true, 'is_return_confirmed' => false,
            ],
        ];

        
        foreach ($loans as $loan) {
            Loan::create($loan);
        }
    }
}
