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
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John Requester',
            'email' => 'john@gmail.com',
            'password' => Hash::make('requester123'),
            'role' => User::ROLE_REQUESTER,
        ]);

        User::create([
            'name' => 'Jane Staff Reviewer',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('staff123'),
            'role' => User::ROLE_STAFF_REVIEWER,
        ]);

        User::create([
            'name' => 'Bob Record Keeper',
            'email' => 'bob@gmail.com',
            'password' => Hash::make('keeper123'),
            'role' => User::ROLE_RECORD_KEEPER,
        ]);
    }
}
