<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use App\Models\IncidentReporting\IncidentReportUser; // 👈 make sure this is correct

class ClearUserData extends Command
{
    protected $signature = 'clear:user-data';
    protected $description = 'Truncate all user-related tables';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        IncidentReportUser::truncate();
        UserRole::truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('✅ User-related tables cleared successfully.');
    }
}
