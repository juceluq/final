<?php

namespace Database\Seeders;

use App\Models\Establishment;
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
        // Crear usuarios
        $adminUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'juanminiyo@outlook.com',
            'username' => 'admin',
            'password' => 'admin',
            'role' => 'admin'
        ]);

        $businessUser = User::factory()->create([
            'name' => 'Business User',
            'email' => 'business@example.com',
            'username' => 'business',
            'password' => 'business',
            'role' => 'business'
        ]);

        $clientUser = User::factory()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'username' => 'client',
            'password' => 'client',
            'role' => 'client'
        ]);

        // Crear establecimientos
        foreach (range(1, 12) as $index) {
            Establishment::factory()->create([
                'user_id' => $businessUser->id,
                'name' => "Business $index",
                'description' => "Description for Business $index",
                'location' => "Location for Business $index",
                'category' => "Category for Business $index",
                'image' => 'images/default.jpg'
            ]);
        }
    }
}
