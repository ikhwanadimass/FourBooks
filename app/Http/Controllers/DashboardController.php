<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        $booksCount = Book::count();
        $loansCount = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->count();
        $loansToday = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->whereDate('loan_date', Carbon::today())
            ->count();
        $lateLoans = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->whereDate('due_date', '<', Carbon::today())
            ->get();
        $lateCount = $lateLoans->count();
        $totalLateFines = $lateLoans->sum(function ($loan) {
            return $loan->calculated_fine;
        });
        $totalLateFines = max(0, $totalLateFines);
        $activities = $this->getRecentActivities();

        return view('dashboard', compact('booksCount', 'loansCount', 'loansToday', 'lateCount', 'totalLateFines', 'activities'));
    }

    public function staff()
    {
        $booksCount = Book::count();
        $loansCount = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->count();
        $loansToday = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->whereDate('loan_date', Carbon::today())
            ->count();
        $lateLoans = Loan::where('status', 'borrowed')
            ->where('is_approved', true)
            ->whereDate('due_date', '<', Carbon::today())
            ->get();
        $lateCount = $lateLoans->count();
        $totalLateFines = $lateLoans->sum(function ($loan) {
            return $loan->calculated_fine;
        });
        $totalLateFines = max(0, $totalLateFines);
        $activities = $this->getRecentActivities();

        return view('staff.dashboard', compact('booksCount', 'loansCount', 'loansToday', 'lateCount', 'totalLateFines', 'activities'));
    }

    protected function getRecentActivities()
    {
        return Loan::with(['user', 'book'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function (Loan $loan) {
                $isPending = !$loan->is_approved;
                $isReturnedPendingConfirmation = $loan->status === 'returned' && !$loan->is_return_confirmed;
                $isActiveBorrowed = $loan->status === 'borrowed' && $loan->is_approved;
                $isReturnConfirmed = $loan->status === 'returned' && $loan->is_return_confirmed;
                $time = $loan->status === 'returned' && $loan->return_date ? Carbon::parse($loan->return_date) : $loan->created_at;

                if ($isPending) {
                    $action = 'mengajukan peminjaman buku';
                    $routeName = 'approve';
                    $buttonLabel = 'Setujui';
                    $color = 'blue';
                    $icon = 'book';
                } elseif ($isReturnedPendingConfirmation) {
                    $action = 'mengembalikan buku';
                    $routeName = 'return';
                    $buttonLabel = 'Konfirmasi';
                    $color = 'green';
                    $icon = 'check-circle';
                } elseif ($isReturnConfirmed) {
                    $action = 'pengembalian dikonfirmasi';
                    $routeName = null;
                    $buttonLabel = null;
                    $color = 'green';
                    $icon = 'check-circle';
                } else {
                    $action = 'sedang meminjam buku';
                    $routeName = null;
                    $buttonLabel = null;
                    $color = 'blue';
                    $icon = 'book';
                }

                return (object)[
                    'id' => $loan->id,
                    'user' => $loan->user?->name ?? 'Pengguna',
                    'book' => $loan->book?->name ?? 'Buku',
                    'action' => $action,
                    'status' => $loan->status,
                    'icon' => $icon,
                    'color' => $color,
                    'timeLabel' => $time->diffForHumans(),
                    'time' => $time->format('d M Y'),
                    'actionRoute' => $routeName,
                    'buttonLabel' => $buttonLabel,
                ];
            });
    }

    public function user()
    {
        // 1. Ambil ID user yang sedang login
        $userId = auth()->id();

        // 2. Ambil data buku untuk widget rekomendasi (Sama seperti sebelumnya)
        $books = Book::all();
        
        // 3. Ambil semua riwayat peminjaman khusus untuk user ini
        $loans = Loan::with('book')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        // 4. Hitung statistik untuk Dashboard
        // Menghitung buku yang sedang dipinjam atau menunggu persetujuan
        $borrowedCount = $loans->whereIn('status', ['borrowed', 'pending'])->count();
        
        // Menghitung buku yang sudah selesai dikembalikan
        $completedCount = $loans->where('status', 'returned')->count();

        // Menghitung total denda yang dimiliki user saat ini
        $fineAmount = $loans->sum(function ($loan) {
            return $loan->calculated_fine; // Menggunakan accessor dari model Loan
        });

        // 5. Kirim semua variabel ke tampilan user.dashboard
        return view('user.dashboard', compact(
            'books', 
            'loans', 
            'borrowedCount', 
            'completedCount', 
            'fineAmount'
        ));
    }
}
