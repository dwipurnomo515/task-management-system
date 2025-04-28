<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $projectManager = Role::create(['name' => 'project_manager']);
        $teamMember = Role::create(['name' => 'team_member']);

        // Project permissions
        $projectPermissions = [
            'view_any_project',
            'view_project',
            'create_project',
            'update_project',
            'delete_project',
            'delete_any_project',
        ];

        // Task permissions
        $taskPermissions = [
            'view_any_task',
            'view_task',
            'create_task',
            'update_task',
            'delete_task',
            'delete_any_task',
        ];

        // Create permissions
        foreach ($projectPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        foreach ($taskPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Super Admin gets everything
        $superAdmin->givePermissionTo(Permission::all());

        // Project Manager permissions
        $projectManager->givePermissionTo([
            'view_any_project',
            'view_project',
            'create_project',
            'update_project',
            'view_any_task',
            'view_task',
            'create_task',
            'update_task',
            'delete_task',
        ]);

        // Team Member permissions
        $teamMember->givePermissionTo([
            'view_any_project',
            'view_project',
            'view_any_task',
            'view_task',
            'update_task',
        ]);
    }
} 