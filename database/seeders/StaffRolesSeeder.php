<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffRolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('staff_roles')->insert([
            [
                'name' => 'Admin',
                'permissions' => json_encode([
                    'create_user', 
                    'manage_roles', 
                    'view_reports', 
                    'assign_roles',
                    'view_all_data'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Loan Officer',
                'permissions' => json_encode([
                    'view_loans', 
                    'approve_loans', 
                    'view_reports'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Branch Manager',
                'permissions' => json_encode([
                    'manage_staff', 
                    'view_branch_data', 
                    'approve_loans'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teller',
                'permissions' => json_encode([
                    'process_transactions', 
                    'view_savings', 
                    'view_clients'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Support',
                'permissions' => json_encode([
                    'view_clients', 
                    'support_queries', 
                    'view_reports'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',  // Default user role
                'permissions' => json_encode([]), // You can define minimal permissions here if needed
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
