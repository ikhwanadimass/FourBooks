<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Memaksa MySQL menerima kata 'pending' ke dalam daftar ENUM
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('pending', 'borrowed', 'returned') NOT NULL DEFAULT 'pending'");
        
        // (Opsional) Jika loan_date dan due_date sebelumnya menolak nilai null, jalankan juga ini:
        // DB::statement("ALTER TABLE loans MODIFY COLUMN loan_date DATE NULL");
        // DB::statement("ALTER TABLE loans MODIFY COLUMN due_date DATE NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('borrowed', 'returned') NOT NULL DEFAULT 'borrowed'");
    }
};