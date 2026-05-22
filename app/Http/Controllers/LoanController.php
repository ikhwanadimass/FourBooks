<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->orderByDesc('loan_date')->get();

        return view('pages.loan.index', compact('loans'));
    }

    // Method baru untuk menerima request AJAX dari halaman Katalog (User)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'book_id' => 'required'
        ]);

        $book = Book::find($request->book_id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan!'], 404);
        }

        if ($book->stock <= 0) {
            return response()->json(['message' => 'Stok buku habis!'], 400);
        }

        // Cek pengajuan yang masih berjalan
        $existingLoan = Loan::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'pending'])
            ->first();

        if ($existingLoan) {
            return response()->json(['message' => 'Anda sudah mengajukan atau sedang meminjam buku ini!'], 400);
        }

        // Menggunakan "new Loan()" untuk membypass proteksi $fillable di model
        $loan = new Loan();
        $loan->user_id = auth()->id();
        $loan->book_id = $book->id;
        $loan->status = 'pending';
        $loan->is_approved = false;
        $loan->is_return_confirmed = false;
        $loan->fine = 0;

        // JANGAN GUNAKAN NULL. MySQL akan menolak jika kolomnya NOT NULL.
        // Beri tanggal sementara (hari ini). Nanti akan ditimpa saat Admin klik "Setujui".
        $loan->loan_date = now()->format('Y-m-d');
        $loan->due_date = now()->addDays(7)->format('Y-m-d');

        $loan->save(); // Simpan paksa ke database

        return response()->json(['message' => 'Pengajuan berhasil dibuat!'], 201);
    }

    public function approveLoan($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->is_approved) {
            return redirect()->back()->with('info', 'Peminjaman sudah disetujui.');
        }

        $loan->loan_date = $loan->loan_date ?? Carbon::now()->format('Y-m-d');
        $loan->due_date = $loan->due_date ?? Carbon::now()->addDays(7)->format('Y-m-d');
        $loan->status = 'borrowed';
        $loan->is_approved = true;
        $loan->save();

        if ($loan->book) {
            $loan->book->decrement('stock');
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function returnBook($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->is_return_confirmed) {
            return redirect()->back()->with('info', 'Pengembalian sudah dikonfirmasi.');
        }

        // 1. Kunci nilai denda berjalan saat ini ke dalam kolom 'fine' di database
        $loan->fine = $loan->calculated_fine;

        // 2. Ubah tanggal pengembalian dan status
        $loan->return_date = Carbon::now()->format('Y-m-d');
        $loan->status = 'returned';
        $loan->is_return_confirmed = true;
        $loan->save();

        if ($loan->book) {
            $loan->book->increment('stock');
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
    public function payFine(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->fine <= 0) {
            return response()->json(['message' => 'Tidak ada denda pada peminjaman ini.'], 400);
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat detail transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'DENDA-' . $loan->id . '-' . time(),
                'gross_amount' => $loan->fine,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
