<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan Role Seeder terlebih dahulu
        $this->call(RoleSeeder::class);

        // Ambil role untuk user
        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $superAdminRole = Role::where('name', 'super_admin')->first();

        // Buat user dengan role 'user' jika belum ada
        User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'John Doe',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
        ]);

        // Buat admin dengan role 'admin' jika belum ada
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // Buat super admin dengan role 'super_admin' jika belum ada
        User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
        ]);
    }
}

