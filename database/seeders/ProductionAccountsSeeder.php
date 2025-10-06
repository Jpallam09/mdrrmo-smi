<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;

class ProductionAccountsSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed staff accounts for incident reporting
        $staffAccounts = [
            [
                'email'      => 'MDRRMO-staff@gmail.com',
                'first_name' => 'MDRRMO',
                'last_name'  => 'Staff',
                'user_name'  => 'mdrrmo.staff',
                'password'   => 'sanmateoisabela@123!',
            ],
            [
                'email'      => 'MDRRMO-staff1@gmail.com',
                'first_name' => 'MDRRMO',
                'last_name'  => 'Staff1',
                'user_name'  => 'mdrrmo.staff1',
                'password'   => 'SanMateoStaff1@123!',
            ],
            [
                'email'      => 'MDRRMO-staff2@gmail.com',
                'first_name' => 'MDRRMO',
                'last_name'  => 'Staff2',
                'user_name'  => 'mdrrmo.staff2',
                'password'   => 'SanMateoStaff2@123!',
            ],
            [
                'email'      => 'MDRRMO-staff3@gmail.com',
                'first_name' => 'MDRRMO',
                'last_name'  => 'Staff3',
                'user_name'  => 'mdrrmo.staff3',
                'password'   => 'SanMateoStaff3@123!',
            ],
            [
                'email'      => 'MDRRMO-staff4@gmail.com',
                'first_name' => 'MDRRMO',
                'last_name'  => 'Staff4',
                'user_name'  => 'mdrrmo.staff4',
                'password'   => 'SanMateoStaff4@123!',
            ],
            [
                'email'      => 'info@example.com',
                'first_name' => 'Info',
                'last_name'  => 'Staff',
                'user_name'  => 'info.staff',
                'password'   => 'InfoStaff@123!',
            ],
            [
                'email'      => 'Sanmateomdrrmorescue309@gmail.com',
                'first_name' => 'Rescue',
                'last_name'  => 'Team',
                'user_name'  => 'rescue.team',
                'password'   => 'RescueTeam@309!',
            ],
        ];

        foreach ($staffAccounts as $account) {
            // Create user if not exists
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'first_name' => $account['first_name'],
                    'last_name'  => $account['last_name'],
                    'user_name'  => $account['user_name'],
                    'password'   => Hash::make($account['password']),
                ]
            );

            // Assign staff role in incident_reporting
            UserRole::firstOrCreate([
                'user_id' => $user->id,
                'app'     => 'incident_reporting',
                'role'    => 'staff',
            ]);
        }
    }
}
