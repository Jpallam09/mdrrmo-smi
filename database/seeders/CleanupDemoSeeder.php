<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanupDemoSeeder extends Seeder
{
    public function run()
    {
        // 1. Delete report images linked to reports
        DB::table('incident_report_images')->whereIn('incident_report_user_id', function ($query) {
            $query->select('id')->from('incident_report_users');
        })->delete();

        // 2. Delete reports
        DB::table('incident_report_users')->delete();

        // 3. Delete demo users
        DB::table('users')->delete();
    }
}
