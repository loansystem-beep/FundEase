<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Repayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'loan_id', 'amount_paid', 'repayment_date', 'status'
    ];

    protected $casts = [
        'repayment_date' => 'datetime',  // Automatically cast to Carbon instance
    ];

    /**
     * Get the loan associated with the repayment.
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the borrower associated with the repayment through the loan.
     */
    public function borrower()
    {
        return $this->hasOneThrough(Borrower::class, Loan::class, 'id', 'id', 'loan_id', 'borrower_id');
    }

    /**
     * Get the user who made the repayment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get recent repayments.
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('repayment_date', 'desc')->limit($limit);
    }

    /**
     * Get formatted repayment date.
     */
    public function getFormattedDateAttribute()
    {
        return $this->repayment_date ? Carbon::parse($this->repayment_date)->format('d M Y') : null;
    }
}
