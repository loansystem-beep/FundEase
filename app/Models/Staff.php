<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    // Define the table associated with the model
    protected $table = 'staff';

    // Define the fillable attributes
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'gender', 
        'country', 
        'staff_role_id', 
        'payroll_branch_id', 
        'mobile', 
        'date_of_birth', 
        'address', 
        'city', 
        'province', 
        'zipcode', 
        'office_phone', 
        'skype', 
        'picture', 
        'results_per_page', 
        'default_view', 
        'login_days', 
        'login_time_from', 
        'login_time_to', 
        'login_timezone', 
        'allowed_ips', 
        'allowed_country', 
        'restrict_loan_dates', 
        'restrict_repayment_dates', 
        'restrict_saving_dates', 
        'restrict_expense_dates', 
        'restrict_income_dates', 
        'require_approval_repayments', 
        'require_approval_savings', 
        'require_approval_journals', 
        'password'
    ];

    // Define relationships

    // Staff belongs to a Staff Role
    public function staffRole()
    {
        return $this->belongsTo(StaffRole::class, 'staff_role_id');
    }

    // Staff belongs to a Payroll Branch
    public function payrollBranch()
    {
        return $this->belongsTo(Branch::class, 'payroll_branch_id');
    }

    // Staff can have many Branches through BranchStaff
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_staff', 'staff_id', 'branch_id');
    }

    // Define any additional methods for business logic if needed

    // Optionally, you can create custom attributes for better access
    // public function getFullNameAttribute()
    // {
    //     return "{$this->first_name} {$this->last_name}";
    // }
}
