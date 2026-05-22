<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'category',
        'author',
        'isbn',
        'stock',
        'status',
        'user_id',
    ];

    protected static function booted()
    {
        static::saving(function ($book) {
            $book->status = $book->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
        });
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
