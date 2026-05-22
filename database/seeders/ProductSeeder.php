<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user or create one
        $user = User::first();

        if ($user) {
            $products = [
                [
                    'name' => 'Tere Liye Dimana Angin Berjatuh',
                    'category' => 'Buku Novel',
                    'price' => 50000,
                    'stock' => 0,
                    'status' => 'Tersedia',
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Tere Liye Dimana Angin Berjatuh',
                    'category' => 'Buku Novel',
                    'price' => 50000,
                    'stock' => 0,
                    'status' => 'Tersedia',
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Tere Liye Dimana Angin Berjatuh',
                    'category' => 'Buku Novel',
                    'price' => 50000,
                    'stock' => 0,
                    'status' => 'Tersedia',
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Tere Liye Dimana Angin Berjatuh',
                    'category' => 'Buku Novel',
                    'price' => 50000,
                    'stock' => 0,
                    'status' => 'Tersedia',
                    'user_id' => $user->id,
                ],
                [
                    'name' => 'Tere Liye Dimana Angin Berjatuh',
                    'category' => 'Buku Novel',
                    'price' => 50000,
                    'stock' => 0,
                    'status' => 'Tersedia',
                    'user_id' => $user->id,
                ],
            ];

            foreach ($products as $product) {
                $product['status'] = $product['stock'] > 0 ? 'Tersedia' : 'Tidak Tersedia';
                Product::create($product);
            }
        }
    }
}
