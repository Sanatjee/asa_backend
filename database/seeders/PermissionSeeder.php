<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [
            // Dashboard
            'dashboard.view',
            'dashboard.stats.view',

            // Knowledge Base
            'program-kb.view',
            'program-kb.create',
            'program-kb.edit',
            'program-kb.delete',

            // Chat
            'chat.view',
            'chat.create',
            'chat.history',

            // Admin Chat Review
            'chat.review',
            'chat.analytics',

            // Users
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
