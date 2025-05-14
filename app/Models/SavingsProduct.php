<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsProduct extends Model
{
    protected $fillable = [
        'name',
        'interest_rate',
        'interest_type',
        'allow_withdrawals',
    ];

    // Relationship with SavingsAccount
    public function savingsAccounts()
    {
        return $this->hasMany(SavingsAccount::class);
    }
}
