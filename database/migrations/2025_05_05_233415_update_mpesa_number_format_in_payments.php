<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Alter the mpesa_number column to fit the new number format
            $table->string('mpesa_number', 13)->change();  // Allow up to 13 characters for numbers starting with 011
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert back to the previous format if needed
            $table->string('mpesa_number', 12)->change();  // For 07xxxxxxxx format
        });
    }
};
