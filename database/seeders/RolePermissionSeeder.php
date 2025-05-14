<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions by role
        $permissions = [
            'Admin1' => [
                'activate users',
                'deactivate users',
                'chat with users',
            ],
            'Admin2' => [
                'create users',
                'update users',
                'delete users',
                'assign roles',
                'manage loans',
                'manage borrowers',
                'view reports',
            ],
            'Loan Officer' => [
                'view loans',
                'manage loans',
                'process repayments',
            ],
            'Branch Manager' => [
                'view branch loans',
                'manage branch staff',
            ],
            'Teller' => [
                'process payments',
                'view borrower payments',
            ],
            'Support' => [
                'view users',
                'assist borrowers',
            ],
        ];

        // Create permissions and assign them to roles
        foreach ($permissions as $roleName => $perms) {
            // Create or get the role
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Assign permissions to the role
            foreach ($perms as $perm) {
                $permission = Permission::firstOrCreate(['name' => $perm]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
