<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\IncidentReporting\IncidentReportUser;
use App\Models\IncidentReporting\IncidentReportImage;

class IncidentReportingSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Step 1: Dummy images
        $dummyImages = [];
        for ($k = 1; $k <= 22; $k++) {
            $dummyImages[] = "dummy/img{$k}.jpg";
        }

        // Step 2: Get all users (500 from DemoUsersSeeder)
        $users = User::all();

        // Step 3: Create 500 reports, randomly distributed across users
        for ($i = 1; $i <= 1000; $i++) {
            $user = $users->random();

            // Create report (force status = "pending")
            $report = IncidentReportUser::create([
                'user_id'           => $user->id,
                'user_name'         => $user->user_name,
                'report_title'      => $faker->sentence(6),
                'report_date'       => $faker->dateTimeBetween('-1 month', 'now'),
                'report_type'       => $faker->randomElement(IncidentReportUser::$types),
                'report_description'=> $faker->paragraph(3),
                'report_status'     => 'pending', // Always pending
            ]);

            // Attach 1–3 images
            $imagesToAttach = $faker->randomElements($dummyImages, rand(1, 3));
            foreach ($imagesToAttach as $img) {
                IncidentReportImage::create([
                    'incident_report_user_id' => $report->id,
                    'file_path' => 'storage/' . $img,
                ]);
            }
        }
    }
}
