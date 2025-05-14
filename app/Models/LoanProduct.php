<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoanProduct extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'unique_id',
        'name',
        'short_name',
        'description',
        'branch_id',
        'branch_access',
        'auto_set_release_date_today',
        'loan_release_date',
        'minimum_principal_amount',
        'default_principal_amount',
        'maximum_principal_amount',
        'disbursed_by',
        'interest_method',
        'interest_type',
        'is_interest_percentage',
        'interest_period',
        'minimum_interest',
        'default_interest',
        'maximum_interest',
        'loan_duration_period',
        'minimum_loan_duration',
        'default_loan_duration',
        'maximum_loan_duration',
        'repayment_cycle',
        'minimum_number_of_repayments',
        'default_number_of_repayments',
        'maximum_number_of_repayments',
        'repayment_order',
        'custom_time_range',
        'extend_after_maturity',
        'interest_type_after_maturity',
        'interest_rate_after_maturity',
        'number_of_repayments_after_maturity',
        'include_fees_after_maturity',
        'keep_past_maturity_status',
        'auto_payments_enabled',
        'start_time',
        'end_time',
        'payment_method',
        'bank_account_id',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'auto_set_release_date_today' => 'boolean',
        'loan_release_date' => 'date',
        'minimum_principal_amount' => 'decimal:2',
        'default_principal_amount' => 'decimal:2',
        'maximum_principal_amount' => 'decimal:2',
        'disbursed_by' => 'string',
        'minimum_interest' => 'decimal:2',
        'default_interest' => 'decimal:2',
        'maximum_interest' => 'decimal:2',
        'minimum_loan_duration' => 'integer',
        'default_loan_duration' => 'integer',
        'maximum_loan_duration' => 'integer',
        'repayment_cycle' => 'string',
        'minimum_number_of_repayments' => 'integer',
        'default_number_of_repayments' => 'integer',
        'maximum_number_of_repayments' => 'integer',
        'repayment_order' => 'array',
        'extend_after_maturity' => 'boolean',
        'interest_type_after_maturity' => 'string',
        'interest_rate_after_maturity' => 'decimal:2',
        'number_of_repayments_after_maturity' => 'integer',
        'include_fees_after_maturity' => 'boolean',
        'keep_past_maturity_status' => 'boolean',
    ];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'loan_product_fee')->withTimestamps();
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    // Accessors
    public function getFormattedReleaseDateAttribute()
    {
        return Carbon::parse($this->loan_release_date)->format('d M Y');
    }

    public function getStartTimeFormattedAttribute()
    {
        return $this->start_time ? Carbon::parse($this->start_time)->format('h:i A') : null;
    }

    public function getEndTimeFormattedAttribute()
    {
        return $this->end_time ? Carbon::parse($this->end_time)->format('h:i A') : null;
    }
}
