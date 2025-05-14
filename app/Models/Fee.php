<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    // Specify which attributes are mass assignable
    protected $fillable = [
        'name',
        'category',
        'calculation_method',
        'calculation_base',
        'default_amount',
        'percentage_value',
        'accounting_method',
        'accounting_type',
        'accrual_journal_entry',
        'cash_journal_entry',
        'description',
    ];

    // Define relationships if needed
    public function loans()
    {
        return $this->belongsToMany(Loan::class)->withPivot('amount'); // Assumes a pivot table like 'loan_fee'
    }
}
