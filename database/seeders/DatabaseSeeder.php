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
        // User::factory(10)->create();

        // Create an admin
        User::factory()->create([
            'name' => 'admin',
            'email' => 'email@example.com',
            'admin' => true,
            'password' => 'admin',
        ]);

        // Create a non-admin test user
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'admin' => false,
            'password' => 'test',
        ]);
    }
}
