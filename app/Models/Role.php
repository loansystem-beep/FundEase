<?php

// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    // Define relationship with permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // Define relationship with users (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class);  // Assuming you have a User model
    }
}
