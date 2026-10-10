<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Laboratory 3 accounts: two fictional students and one administrator.
     */
    private const ACCOUNTS = [
        [
            'name' => 'Jane Lim',
            'email' => 'jane.lim@school.edu',
            'password' => 'student123',
            'role' => User::ROLE_STUDENT,
        ],
        [
            'name' => 'Alon Cruz',
            'email' => 'alon.cruz@school.edu',
            'password' => 'student123',
            'role' => User::ROLE_STUDENT,
        ],
        [
            'name' => 'Mike Santos',
            'email' => 'mike.s@gmail.com',
            'password' => 'admin123',
            'role' => User::ROLE_ADMINISTRATOR,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emails = array_column(self::ACCOUNTS, 'email');

        // Remove the Laboratory 2 role accounts that are no longer part of the system.
        User::whereNotIn('email', $emails)->delete();

        foreach (self::ACCOUNTS as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'role' => $account['role'],
                ]
            );
        }
    }
}
