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
            // Ensure 'extend_after_maturity' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'extend_after_maturity')) {
                $table->boolean('extend_after_maturity')->default(false);
            }

            // Ensure 'interest_type_after_maturity' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'interest_type_after_maturity')) {
                $table->enum('interest_type_after_maturity', ['percentage', 'fixed'])->nullable();
            }

            // Ensure 'interest_rate_after_maturity' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'interest_rate_after_maturity')) {
                $table->decimal('interest_rate_after_maturity', 8, 2)->nullable();
            }

            // Ensure 'number_of_repayments_after_maturity' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'number_of_repayments_after_maturity')) {
                $table->integer('number_of_repayments_after_maturity')->nullable();
            }

            // Ensure 'include_fees_after_maturity' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'include_fees_after_maturity')) {
                $table->boolean('include_fees_after_maturity')->default(false);
            }

            // Ensure 'keep_past_maturity_status' column exists and is set properly
            if (!Schema::hasColumn('loan_products', 'keep_past_maturity_status')) {
                $table->boolean('keep_past_maturity_status')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            // Drop the columns if needed
            $table->dropColumn([
                'extend_after_maturity',
                'interest_type_after_maturity',
                'interest_rate_after_maturity',
                'number_of_repayments_after_maturity',
                'include_fees_after_maturity',
                'keep_past_maturity_status'
            ]);
        });
    }
};
