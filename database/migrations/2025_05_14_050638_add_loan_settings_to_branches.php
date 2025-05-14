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
        Schema::table('branches', function (Blueprint $table) {
            // Loan Amount Settings
            $table->decimal('min_loan_amount', 15, 2)->nullable()->after('description');
            $table->decimal('max_loan_amount', 15, 2)->nullable()->after('min_loan_amount');

            // Interest Rate Settings
            $table->decimal('min_interest_rate', 5, 2)->nullable()->after('max_loan_amount');
            $table->decimal('max_interest_rate', 5, 2)->nullable()->after('min_interest_rate');

            // Optionally, holidays as a JSON field
            $table->json('holidays')->nullable()->after('max_interest_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            // Drop the columns if the migration is rolled back
            $table->dropColumn([
                'min_loan_amount', 
                'max_loan_amount', 
                'min_interest_rate', 
                'max_interest_rate', 
                'holidays'
            ]);
        });
    }
};
