<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffRole extends Model
{
    // Define the table name (optional if Laravel's default pluralization works)
    protected $table = 'staff_roles';

    // Define the fillable attributes
    protected $fillable = [
        'name',           // Role name (e.g. Admin, Branch Manager)
        'description',    // Optional: description of the role
        'permissions',    // Optional: store serialized permissions (JSON or array)
    ];

    // Cast permissions to array if stored as JSON
    protected $casts = [
        'permissions' => 'array',
    ];

    // Define relationship: one role has many staff members
    public function staff()
    {
        return $this->hasMany(Staff::class, 'staff_role_id');
    }
}
