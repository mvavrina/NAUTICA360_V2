<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get the first 10 yachts
        $yachts = DB::table('api_yachts')->limit(10)->pluck('id');

        foreach ($yachts as $yacht_id) {
            DB::table('reservations')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'tel' => $faker->phoneNumber,
                'date_from' => $faker->dateTimeBetween('+1 days', '+1 month'),
                'date_to' => $faker->dateTimeBetween('+1 month', '+2 months'),
                'reserved' => $faker->dateTimeThisYear(),
                'yacht_id' => $yacht_id,
                'price' => $faker->randomFloat(2, 1000, 5000), // Random price between 1000 and 5000
                'discount' => $faker->randomFloat(2, 0, 500), // Random discount between 0 and 500
                'base_price' => $faker->randomFloat(2, 1000, 5000), // Random base price
                'note' => $faker->optional()->sentence, // Optional note
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
