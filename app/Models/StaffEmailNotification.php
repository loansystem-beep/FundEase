<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffEmailNotification extends Model
{
    // Optional: use timestamps for record keeping
    public $timestamps = true;

    // Define the table name explicitly if needed
    protected $table = 'staff_email_notifications';

    // Fields that can be mass-assigned
    protected $fillable = [
        'staff_id',
        'daily_loans_due',               // boolean: receive daily notification for loans due today
        'daily_loans_expiring',          // boolean: receive notification for loans expiring today
        'daily_loans_past_maturity',     // boolean: receive notification for loans past maturity
        'daily_new_loans_added',         // boolean: notification for new loans
        'daily_new_repayments_added',    // boolean: notification for new repayments
        'weekly_reports',                // boolean: receive weekly summary
        'notify_repayment_approval',     // boolean: notified when repayments are pending approval
        'notify_savings_approval',       // boolean: notified when savings are pending approval
        'notify_journal_approval',       // boolean: notified when manual journal is pending approval
    ];

    // Relationship: Each notification setting belongs to a staff member
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
