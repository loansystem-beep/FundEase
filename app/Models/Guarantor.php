<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guarantor extends Model
{
    protected $fillable = [
        'country',
        'first_name',
        'middle_last_name',
        'business_name',
        'unique_number',
        'gender',
        'title',
        'mobile',
        'email',
        'dob',
        'address',
        'city',
        'province',
        'zipcode',
        'landline_phone',
        'working_status',
        'photo',
        'description',
        'loan_officer_id',
    ];

    /**
     * Get the full name of the guarantor.
     */
    public function getFullNameAttribute(): string
    {
        if ($this->business_name) {
            return $this->business_name;
        }

        return trim("{$this->first_name} {$this->middle_last_name}");
    }

    /**
     * Relationship: Guarantor belongs to a Loan Officer (User).
     */
    public function loanOfficer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'loan_officer_id');
    }
}
