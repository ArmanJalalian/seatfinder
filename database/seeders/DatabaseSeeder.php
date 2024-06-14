<?php

namespace Database\Seeders;

use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 screens
        Screen::factory()
            ->count(5)
            ->create()
            ->each(function ($screen) {
                // Generate a unique range of seat numbers for each screen
                $seatingCapacity = $screen->seating_capacity;
                $seatNumbers = range(1, $seatingCapacity);
                shuffle($seatNumbers);

                foreach (array_slice($seatNumbers, 0, rand(1, $seatingCapacity)) as $seatNumber) {
                    Seat::factory()->create([
                        'screen_id' => $screen->id,
                        'seat_number' => $seatNumber,
                    ]);
                }
            });
    }
}
