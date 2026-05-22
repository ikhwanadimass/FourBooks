<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    // TAMBAHKAN BARIS INI untuk mengizinkan input data ke kolom database
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'is_approved',
        'loan_date',
        'due_date',
        'return_date',
        'fine'
    ];

    protected $dendaPerHari = 5000;

    protected $casts = [
        'is_approved' => 'boolean',
        'is_return_confirmed' => 'boolean',
    ];

    /**
     * Accessor untuk menghitung denda secara dinamis.
     * Panggil dengan cara: $loan->calculated_fine
     */
    public function getCalculatedFineAttribute()
    {
        // 1. Jika buku sudah dikembalikan, pakai nilai denda yang sudah permanen di DB
        if ($this->status === 'returned' || !is_null($this->return_date)) {
            return $this->fine;
        }

        // 2. Jika belum dikembalikan, cek apakah sudah melewati batas waktu (due_date)
        if (is_null($this->due_date)) {
            return 0;
        }
        
        $dueDate = Carbon::parse($this->due_date);
        $hariIni = Carbon::now()->startOfDay();

        if ($hariIni->gt($dueDate)) {
            // Hitung selisih hari keterlambatan
            $selisihHari = abs($hariIni->diffInDays($dueDate));
            
            // Hitung total denda
            return $selisihHari * $this->dendaPerHari;
        }

        // 3. Jika belum lewat batas waktu, denda tetap 0
        return 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}