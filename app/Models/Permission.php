<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    // Use HasFactory if you're using factories for testing or seeding
    // use HasFactory;

    // Table name (if different from the plural form of the model name)
    protected $table = 'permissions';

    // The attributes that are mass assignable
    protected $fillable = ['name', 'guard_name'];

    // If you're not using timestamps, set this to false
    public $timestamps = true; 

    // Optionally, you can define custom timestamp columns
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
}
