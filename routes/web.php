<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (!auth()->check()) {
        return view('welcome');
    }

    // Redirect based on role
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        'user' => redirect()->route('user.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->name('home');

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('loans', LoanController::class)->only(['index']);
    Route::post('loans/{loan}/approve', [LoanController::class, 'approveLoan'])->name('loans.approve');
    Route::post('loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    Route::resource('accounts', AccountController::class)->only(['index', 'store', 'destroy']);
});

// Staff routes
Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'staff'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('loans', LoanController::class)->only(['index']);
    Route::post('loans/{loan}/approve', [LoanController::class, 'approveLoan'])->name('loans.approve');
    Route::post('loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
});

// User routes
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'user'])->name('dashboard');

    Route::get('catalog', function () {
        $books = \App\Models\Book::all();
        return view('user.catalog', compact('books'));
    })->name('catalog');

    Route::get('cart', function () {
        return view('user.cart');
    })->name('cart');

    Route::get('history', function () {
        $loans = \App\Models\Loan::with('book')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($loan) {
                // Menambahkan atribut denda agar mudah dibaca oleh JavaScript
                $loan->calculated_fine_value = $loan->calculated_fine;

                // Menentukan apakah buku terlambat
                $isOverdue = $loan->due_date && \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($loan->due_date));
                $loan->is_overdue = $isOverdue && $loan->status === 'borrowed';

                return $loan;
            });

        return view('user.history', compact('loans'));
    })->name('history');

    Route::post('/loans/store', [App\Http\Controllers\LoanController::class, 'store'])->name('loans.store');

    // RUTE UNTUK AKSI DI HALAMAN HISTORY (Pastikan method ini ada di controller kamu)
    Route::post('/loans/{id}/return', [App\Http\Controllers\LoanController::class, 'returnBook'])->name('loans.return');
    Route::post('/loans/{id}/pay', [App\Http\Controllers\LoanController::class, 'payFine'])->name('loans.pay');
    Route::post('/loans/store', [App\Http\Controllers\LoanController::class, 'store'])->name('loans.store');
});


// Keep old /dashboard route for backward compatibility & Fortify redirect
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
