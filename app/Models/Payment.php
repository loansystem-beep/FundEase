<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'mpesa_number',
        'mpesa_transaction_code',
        'paid_at',
        'checkout_request_id',  // Added field
    ];

    protected $dates = [
        'paid_at',
    ];

    // Cast the status field to ensure it's treated as a string
    protected $casts = [
        'status' => 'string',
    ];

    // Define constants for the possible statuses
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    /**
     * Get the user that made the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include payments with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get all payments with a specific status (e.g., completed).
     */
    public static function getCompletedPayments()
    {
        return self::where('status', self::STATUS_COMPLETED)->get();
    }

    /**
     * Get all payments with a specific status (e.g., pending).
     */
    public static function getPendingPayments()
    {
        return self::where('status', self::STATUS_PENDING)->get();
    }

    /**
     * Get all payments with a specific status (e.g., failed).
     */
    public static function getFailedPayments()
    {
        return self::where('status', self::STATUS_FAILED)->get();
    }
}
