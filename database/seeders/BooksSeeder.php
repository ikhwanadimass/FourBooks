<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil ID user pertama yang ada di database untuk relasi user_id
        // Jika belum ada user sama sekali, pastikan UserSeeder dijalankan duluan
        $userId = User::first()?->id ?? 1;

        $books = [
            [
                'name' => 'Belajar Laravel 11 untuk Pemula',
                'category' => 'Pemrograman',
                'author' => 'Sandhika Galih',
                'isbn' => '978-602-052-123-4',
                'stock' => 10,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Membangun Web API dengan Node.js',
                'category' => 'Pemrograman',
                'author' => 'Alex Handoko',
                'isbn' => '978-602-052-567-8',
                'stock' => 5,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Algoritma dan Struktur Data C++',
                'category' => 'Edukasi',
                'author' => 'Dr. Indah Permata',
                'isbn' => '978-602-052-999-0',
                'stock' => 0,
                'status' => 'Tidak Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Dunia di Dalam Lingkaran',
                'category' => 'Novel',
                'author' => 'Siti Aminah',
                'isbn' => '978-602-052-443-2',
                'stock' => 7,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Dasar-Dasar UI/UX Design',
                'category' => 'Desain',
                'author' => 'Kevin Sanjaya',
                'isbn' => '978-602-052-887-6',
                'stock' => 3,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            // Tambahan 15 buku baru
            [
                'name' => 'Mahir Laravel dan PostgreSQL',
                'category' => 'Pemrograman',
                'author' => 'Budi Setiawan',
                'isbn' => '978-602-052-111-1',
                'stock' => 15,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Implementasi Linked List dan Queue',
                'category' => 'Pemrograman',
                'author' => 'Rina Wijaya',
                'isbn' => '978-602-052-222-2',
                'stock' => 8,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Arsitektur Aplikasi Cashier (POS)',
                'category' => 'Edukasi',
                'author' => 'Dimas Anggara',
                'isbn' => '978-602-052-333-3',
                'stock' => 4,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Jejak Petualang di Zona Anomali',
                'category' => 'Novel',
                'author' => 'Dika Utama',
                'isbn' => '978-602-052-444-4',
                'stock' => 5,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Dasar Modding Game PC dan Shaders',
                'category' => 'Desain',
                'author' => 'Hendra Pratama',
                'isbn' => '978-602-052-555-5',
                'stock' => 6,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Rahasia Kedai Kopi Pinggir Jalan',
                'category' => 'Novel',
                'author' => 'Nisa Rahmawati',
                'isbn' => '978-602-052-666-6',
                'stock' => 12,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Merakit Mechanical Keyboard untuk Pemula',
                'category' => 'Edukasi',
                'author' => 'Rizky Ramadhan',
                'isbn' => '978-602-052-777-7',
                'stock' => 0,
                'status' => 'Tidak Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Panduan Mikrokontroler ESP32 & Arduino',
                'category' => 'Pemrograman',
                'author' => 'Eko Purwanto',
                'isbn' => '978-602-052-888-8',
                'stock' => 20,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Sistem Monitoring Panel Surya Berbasis Web',
                'category' => 'Edukasi',
                'author' => 'Dr. Surya Darma',
                'isbn' => '978-602-052-999-9',
                'stock' => 5,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Membangun Website Profil Organisasi',
                'category' => 'Pemrograman',
                'author' => 'Citra Dewi',
                'isbn' => '978-602-052-000-0',
                'stock' => 9,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Pelarian dari Tarkov',
                'category' => 'Novel',
                'author' => 'Ivan Ivanov',
                'isbn' => '978-602-053-111-2',
                'stock' => 2,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Desain Tiling Window Manager di OS',
                'category' => 'Desain',
                'author' => 'Alex Chandra',
                'isbn' => '978-602-053-222-3',
                'stock' => 7,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Eksplorasi Efek Audio pada Instrumen',
                'category' => 'Edukasi',
                'author' => 'Gilang Ramadhan',
                'isbn' => '978-602-053-333-4',
                'stock' => 0,
                'status' => 'Tidak Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Pengenalan Jaringan Komputer',
                'category' => 'Edukasi',
                'author' => 'Andi Susanto',
                'isbn' => '978-602-053-444-5',
                'stock' => 15,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
            [
                'name' => 'Misteri Modifikasi Mesin Motor',
                'category' => 'Edukasi',
                'author' => 'Bagas Prasetyo',
                'isbn' => '978-602-053-555-6',
                'stock' => 3,
                'status' => 'Tersedia',
                'user_id' => $userId,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}