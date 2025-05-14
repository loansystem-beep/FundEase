<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'banks';

    // Fillable attributes to allow mass assignment
    protected $fillable = [
        'code',
        'bank_account_name',
        'account_name',
        'currency',
        'loan_categories',
        'repayment_categories',
        'expense_categories',
        'income_categories',
        'transaction_categories',
        'branch_capital_categories',
        'payroll_categories',
        'is_default', // Removed 'branches'
    ];

    // Cast JSON attributes to arrays
    protected $casts = [
        'loan_categories' => 'array',
        'repayment_categories' => 'array',
        'expense_categories' => 'array',
        'income_categories' => 'array',
        'transaction_categories' => 'array',
        'branch_capital_categories' => 'array',
        'payroll_categories' => 'array',
        // Removed 'branches' cast
    ];

    /**
     * Get the branches associated with the bank.
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_bank', 'bank_id', 'branch_id')
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include default banks.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
