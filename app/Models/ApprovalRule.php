<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRule extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow the default naming convention
    protected $table = 'approval_rules';

    // Specify the fillable columns for mass assignment
    protected $fillable = [
        'rule_name',
        'description',
        'min_value',
        'max_value',
        'role_name',
    ];

    // If needed, you can define relationships, for example:
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }
}
