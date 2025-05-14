<?php

// app/Models/SavingsAccount.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsAccount extends Model
{
    protected $fillable = [
        'user_id', 'borrower_id', 'savings_product_id', 'account_number', 'balance', 'account_type', 'description'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Borrower
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    // Relationship with SavingsProduct
    public function savingsProduct()
    {
        return $this->belongsTo(SavingsProduct::class);
    }
}
