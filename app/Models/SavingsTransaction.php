<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'savings_account_id',
        'borrower_id',             // For the borrower relation
        'borrower_first_name',     // Borrower's first name
        'borrower_last_name',      // Borrower's last name
        'action',
        'account_number',
        'ledger_balance',
        'transaction_date',
        'type',
        'description',
        'debit',
        'credit',
        'receipt',
    ];

    /**
     * Get the savings account associated with the transaction.
     */
    public function savingsAccount()
    {
        return $this->belongsTo(SavingsAccount::class);
    }

    /**
     * Get the borrower associated with the transaction.
     */
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
}
