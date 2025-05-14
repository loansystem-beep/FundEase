<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'file_path',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
