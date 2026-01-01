<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles from database
        $adminRole = Role::where('name', 'admin')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Check if roles exist
        if (!$adminRole || !$customerRole) {
            $this->command->error('Roles not found! Please run RoleSeeder first.');
            return;
        }

        // 1. Create Admin Account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Password: admin123
            'role_id' => $adminRole->id,
            'phone_number' => '081234567890',
        ]);

        $this->command->info('Admin user created successfully.');

        // 2. Create Customer Account
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => $customerRole->id,
            'phone_number' => '089876543210',
        ]);

        $this->command->info('Customer user created successfully.');
    }
}