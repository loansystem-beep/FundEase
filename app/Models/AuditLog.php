<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    // Optional: use timestamps to track when the log was created
    public $timestamps = true;

    // Define the table name explicitly if needed
    protected $table = 'audit_logs';

    // Fields that can be mass-assigned
    protected $fillable = [
        'staff_id',        // ID of the staff who performed the action
        'action',          // What action was performed (e.g., 'created loan', 'deleted borrower')
        'model_type',      // The model/entity affected (e.g., 'Loan', 'Borrower')
        'model_id',        // The specific ID of the affected model
        'description',     // Optional human-readable description
        'ip_address',      // IP address of the staff during the action
        'user_agent'       // Browser or client details
    ];

    // Relationship: Each log belongs to a staff member
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
