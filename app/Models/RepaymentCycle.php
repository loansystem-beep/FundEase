<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepaymentCycle extends Model
{
    protected $fillable = [
        'name',
        'type',
        'every_x_days',
        'fixed_monthly_dates',
        'fixed_weekly_days',
    ];

    protected $casts = [
        'fixed_monthly_dates' => 'array',
        'fixed_weekly_days' => 'array',
    ];
}
