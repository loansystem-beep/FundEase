<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'account_number',
        'bank_name',
        'branch',
        'swift_code',
        'is_active',
    ];

    // Cast booleans to the appropriate type.
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full account details as a string (useful for displaying in select options).
     *
     * @return string
     */
    public function getAccountDetailsAttribute()
    {
        return $this->bank_name . ' - ' . $this->account_number;
    }

    /**
     * The loan products that belong to the bank account.
     */
    public function loanProducts()
    {
        return $this->hasMany(LoanProduct::class); // Assuming LoanProduct has a bank_account_id
    }
}
