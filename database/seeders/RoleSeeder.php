<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $counselor = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => 'web',
        ]);

        // Admin gets everything
        $admin->syncPermissions(Permission::all());

        // Counselor permissions
        $counselor->syncPermissions([
            'dashboard.view',
            'chat.view',
            'chat.create',
            'chat.history',
            'program-kb.view',
        ]);
    }
}
