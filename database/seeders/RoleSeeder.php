<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'user',
        ], [
            'description' => 'Regular User',
        ]);

        Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'description' => 'Administrator',
        ]);

        Role::firstOrCreate([
            'name' => 'super_admin',
        ], [
            'description' => 'Super Administrator',
        ]);
    }
}
