<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPhoneNumberColumnReferenceInBorrowers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // If there's any erroneous reference to phone_number in this migration, we fix it here
            // Make sure no actions are attempted for 'phone_number' if it doesn't exist
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // If the column phone_number was wrongly attempted for removal, handle it here
        });
    }
};
