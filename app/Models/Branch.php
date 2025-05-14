<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'currency',
        'country',
        'date_format',
        'address',
        'phone',
        'email',
        'description',

        // New settings fields
        'min_loan_amount',
        'max_loan_amount',
        'min_interest_rate',
        'max_interest_rate',
        'holidays',
    ];

    protected $casts = [
        'holidays' => 'array',
    ];
}
