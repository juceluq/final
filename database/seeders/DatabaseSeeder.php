<?php

namespace Database\Seeders;

use App\Models\Establishment;
use App\Models\Reserva;
use App\Models\Review;
use App\Models\User;
use App\Models\Vote;
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
            $establishment = Establishment::factory()->create([
                'user_id' => $businessUser->id,
                'name' => "Business $index",
                'description' => "Description for Business $index",
                'location' => "Location for Business $index",
                'category' => "Category for Business $index",
                'price' => 10.00
            ]);

            foreach (range(1, 3) as $imgIndex) {
                $filename = "default/default.jpg";

                $establishment->images()->create(['filename' => $filename]);
            }
            foreach (range(1, 5) as $reservaIndex) {
                Reserva::factory()->create([
                    'user_id' => $clientUser->id,
                    'establishment_id' => $establishment->id,
                    'start_date' => now()->addDays($reservaIndex * 10),
                    'end_date' => now()->addDays($reservaIndex * 10 + 5),
                    'phone' => rand(600000000, 699999999),
                    'price' => rand(100, 500)
                ]);
            }

            foreach (range(1, 5) as $reviewIndex) {
                Review::factory()->create([
                    'reserva_id' => $establishment->reservas->random()->id,
                    'user_id' => $clientUser->id,
                    'establishment_id' => $establishment->id,
                    'rating' => rand(1, 5),
                    'comment' => "This is a sample review $reviewIndex for Establishment $index",
                    'review_date' => now()->subDays(rand(1, 365))
                ]);
            }
            foreach (range(1, 60) as $votes) {
                Vote::factory()->create([
                    'user_id' => $clientUser->id,
                    'review_id' => $votes,
                    'type' => rand(0, 1)
                ]);
            }
        }
    }
}
