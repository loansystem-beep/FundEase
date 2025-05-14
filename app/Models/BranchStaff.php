<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStaff extends Model
{
    // Optional: if you plan to use timestamps like created_at/updated_at
    public $timestamps = true;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'branch_staff';

    // Define which fields are mass assignable
    protected $fillable = [
        'branch_id',
        'staff_id',
        // You can add additional fields like:
        // 'assigned_by',
        // 'note',
    ];

    // Relationships

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
