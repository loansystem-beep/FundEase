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
        Schema::table('repayment_cycles', function (Blueprint $table) {
            // Add the 'fixed_monthly_dates' column to the repayment_cycles table
            $table->string('fixed_monthly_dates')->nullable(); // Adjust the type if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repayment_cycles', function (Blueprint $table) {
            // Drop the 'fixed_monthly_dates' column in case of rollback
            $table->dropColumn('fixed_monthly_dates');
        });
    }
};
