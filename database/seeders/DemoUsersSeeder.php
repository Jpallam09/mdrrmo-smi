<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create demo users
        for ($i = 1; $i <= 500; $i++) {
            User::create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'user_name'  => $faker->unique()->userName,  // random but unique username
                'email'      => $faker->unique()->safeEmail,
                'phone'      => $faker->phoneNumber,
                'password'   => Hash::make('password'), // default password
            ]);
        }
    }
}
