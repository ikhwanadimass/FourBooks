<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    if (!auth()->check()) {
        return view('pages.auth.login');
    }

    // Redirect based on role
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'staff' => redirect()->route('staff.dashboard'),
        default => redirect()->route('admin.dashboard'),
    };
})->name('home');

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('accounts', AccountController::class)->only(['index', 'store', 'destroy']);
});

// Staff routes
Route::middleware(['auth', 'verified', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::view('dashboard', 'staff.dashboard')->name('dashboard');
    Route::resource('products', ProductController::class);
});

// Keep old /dashboard route for backward compatibility & Fortify redirect
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'staff' => redirect()->route('staff.dashboard'),
            default => redirect()->route('admin.dashboard'),
        };
    })->name('dashboard');
});

require __DIR__.'/settings.php';
