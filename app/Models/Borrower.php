<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Borrower extends Model
{
    use HasFactory;

    protected $table = 'borrowers';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Mass assignable fields (ensure all necessary fields are included)
    protected $fillable = [
        'user_id',          // Add this field to link borrower to user
        'borrower_type',
        'first_name',
        'last_name',
        'business_name',
        'date_of_birth',
        'email',
        'phone_number',     // Ensure this is included
        'gender',
        'description',
        'title',
        'address',
        'custom_fields',
        'status',           // Active or Inactive
        'loan_status',      // Active, Cleared, or Defaulted
        'city',             // Location fields
        'country',          // Location fields
        'postal_code',      // Location fields
        'photo',            // Optional photo field
    ];

    protected $appends = ['full_name', 'formatted_phone_number'];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'borrower_id');
    }

    public function repayments(): HasMany
    {
        return $this->hasManyThrough(Repayment::class, Loan::class, 'borrower_id', 'loan_id');
    }

    public function latestLoan(): HasOne
    {
        return $this->hasOne(Loan::class, 'borrower_id')->latestOfMany();
    }

    // Many-to-Many relationship with User
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'borrower_user', 'borrower_id', 'user_id')
                    ->withTimestamps();  // Optional, to record when the relationship was created/updated
    }

    // Many-to-Many relationship with BorrowerGroup
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(BorrowerGroup::class, 'borrower_borrower_group');
    }

    // Get total loan amount borrowed
    public function getTotalLoanAmountAttribute()
    {
        return $this->loans->sum('amount');
    }

    // Get outstanding balance
    public function getOutstandingBalanceAttribute()
    {
        return $this->loans->sum(function ($loan) {
            return max(0, $loan->amount - $loan->repayments->sum('amount_paid'));
        });
    }

    // Accessors & Mutators
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = preg_replace('/\D/', '', $value);
    }

    public function getFormattedPhoneNumberAttribute()
    {
        if (!$this->phone_number) return null;
        return sprintf("(%s) %s-%s",
            substr($this->phone_number, 0, 3),
            substr($this->phone_number, 3, 3),
            substr($this->phone_number, 6)
        );
    }

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefaulters(Builder $query)
    {
        return $query->where('loan_status', 'defaulted');
    }

    public function scopeWithOutstandingBalance(Builder $query)
    {
        return $query->whereHas('loans', function ($q) {
            $q->whereRaw('(amount - COALESCE((SELECT SUM(amount_paid) FROM repayments WHERE repayments.loan_id = loans.id), 0)) > 0');
        });
    }

    // Static Methods
    public static function activeCount()
    {
        return self::active()->count();
    }

    public static function defaulterCount()
    {
        return self::defaulters()->count();
    }

    public static function defaultRate()
    {
        $totalBorrowers = self::count();
        $defaulters = self::defaulters()->count();
        return $totalBorrowers > 0 ? round(($defaulters / $totalBorrowers) * 100, 2) : 0;
    }

    public static function outstandingList()
    {
        return self::withOutstandingBalance()->get();
    }

    // Custom validation for uniqueness of email per user_id
    public static function validateUniqueEmail($email, $userId, $excludeId = null)
    {
        return !self::where('email', $email)
                    ->where('user_id', $userId)
                    ->where('id', '!=', $excludeId)  // Exclude the current record if updating
                    ->exists();
    }
}
