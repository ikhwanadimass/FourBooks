<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('pages.auth.login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('products', ProductController::class);
    });
    
Route::middleware(['auth', 'verified', 'role:super_admin'])->group(function () {
    Route::resource('accounts', AccountController::class)->only(['index', 'store', 'destroy']);
});
require __DIR__.'/settings.php';
