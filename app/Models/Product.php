<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'status',
        'icon',
        'user_id',
    ];

    protected static function booted()
    {
        static::saving(function ($product) {
            $product->status = $product->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
