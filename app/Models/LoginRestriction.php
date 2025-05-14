<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginRestriction extends Model
{
    protected $fillable = [
        'ip_address', 'device', 'location', 'is_allowed'
    ];
}
