<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Seed the application's accounts/users.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (User::where('email', 'test@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'Atmin',
                'email' => 'admin@fourbooks.com',
                'role' => 'admin',
            ]);
        } else {
            // Update existing user to admin
            User::where('email', 'admin@fourbooks.com')->update(['role' => 'admin']);
        }

        // Create staff user if not exists
        if (User::where('email', 'staff@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'ExStaff',
                'email' => 'staff@example.com',
                'role' => 'staff',
            ]);
        } else {
            // Update existing user to staff
            User::where('email', 'staff@example.com')->update(['role' => 'staff']);
        }

        // Create standard user if not exists
        if (User::where('email', 'user@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'ExUser',
                'email' => 'user@example.com',
                'role' => 'user',
            ]);
        } else {
            // Update existing user to user
            User::where('email', 'user@example.com')->update(['role' => 'user']);
        }
        if (User::where('email', 'user2@example.com')->doesntExist()) {
            User::factory()->create([
                'name' => 'ExUser2',
                'email' => 'user2@example.com',
                'role' => 'user',
            ]);
        } else {
            // Update existing user to user
            User::where('email', 'user2@example.com')->update(['role' => 'user']);
        }
    }
}
