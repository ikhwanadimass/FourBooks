<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('status');
            $table->boolean('is_return_confirmed')->default(false)->after('is_approved');
        });

        \DB::table('loans')->where('status', 'borrowed')->update(['is_approved' => true]);
        \DB::table('loans')->where('status', 'returned')->update(['is_approved' => true, 'is_return_confirmed' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['is_approved', 'is_return_confirmed']);
        });
    }
};
