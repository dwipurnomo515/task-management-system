<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Project Manager
        $projectManager = User::create([
            'name' => 'Project Manager',
            'email' => 'pm@example.com',
            'password' => Hash::make('password'),
        ]);
        $projectManager->assignRole('project_manager');

        // Team Member 1
        $teamMember1 = User::create([
            'name' => 'Team Member 1',
            'email' => 'tm1@example.com',
            'password' => Hash::make('password'),
        ]);
        $teamMember1->assignRole('team_member');

        // Team Member 2
        $teamMember2 = User::create([
            'name' => 'Team Member 2',
            'email' => 'tm2@example.com',
            'password' => Hash::make('password'),
        ]);
        $teamMember2->assignRole('team_member');
    }
} 