<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    // Specify the table name if it doesn't follow Laravel's pluralization convention
    protected $table = 'loan_repayments';  // Adjust this if your table name differs

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'loan_product_id',
        'due_date',
        'status',
        'payment_date',
        'amount',
        // Add any other fields relevant to repayments
    ];

    // Define the relationship to the LoanProduct model
    public function loanProduct()
    {
        return $this->belongsTo(LoanProduct::class, 'loan_product_id');
    }
}
