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
            // Add fixed_weekly_days column if it doesn't already exist
            if (!Schema::hasColumn('repayment_cycles', 'fixed_weekly_days')) {
                $table->string('fixed_weekly_days')->nullable()->after('fixed_monthly_dates');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repayment_cycles', function (Blueprint $table) {
            $table->dropColumn('fixed_weekly_days');
        });
    }
};
