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
        Schema::table('loan_products', function (Blueprint $table) {
            // Add Repayment Fields
            $table->enum('repayment_cycle', [
                'Daily', 'Weekly', 'Biweekly', 'Monthly', 'Bimonthly', 'Quarterly',
                'Every 4 Months', 'Semi-Annual', 'Every 9 Months', 'Yearly', 'Lump-Sum'
            ])->nullable();
            $table->integer('minimum_number_of_repayments')->nullable();
            $table->integer('default_number_of_repayments')->nullable();
            $table->integer('maximum_number_of_repayments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            // Drop repayment fields if rollback happens
            $table->dropColumn([
                'repayment_cycle', 
                'minimum_number_of_repayments', 
                'default_number_of_repayments', 
                'maximum_number_of_repayments'
            ]);
        });
    }
};
