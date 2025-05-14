<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'action',
        'details',
    ];

    /**
     * Define the relationship: An activity belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a new activity.
     */
    public static function log($userId, $action, $details = null): Activity
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'details' => $details,
        ]);
    }
}
