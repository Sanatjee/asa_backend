<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'senthil@iitbeo.com',
            ],
            [
                'name' => 'P Senthil Kumar',
                'phone' => '9999999999',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $admin->syncRoles(['Admin']);
    }
}
