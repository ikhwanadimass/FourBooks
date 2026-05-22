<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user if not exists
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'admin',
            ]);
        } else {
            // Update existing user to admin
            User::where('email', 'test@example.com')->update(['role' => 'admin']);
        }

        $this->call(ProductSeeder::class);
    }
}
