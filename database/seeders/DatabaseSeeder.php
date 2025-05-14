<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RolePermissionSeeder; // Make sure to import your RolePermissionSeeder class

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user (you can remove this if you want)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call the RolePermissionSeeder to seed the roles and permissions
        $this->call([
            RolePermissionSeeder::class, // Add the RolePermissionSeeder here
        ]);
    }
}
