<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'admin',
            'email' => 'email@example.com',
            'admin' => true,
            'password' => 'admin',
        ]);

        // Create 50 non-admin users
        User::factory(50)->create([
            'admin' => false,
            'password' => 'test',
        ]);
    }
}
