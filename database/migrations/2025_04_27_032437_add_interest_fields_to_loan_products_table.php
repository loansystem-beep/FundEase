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
            $table->string('interest_method')->nullable(); // e.g., 'percentage' or 'fixed'
            $table->string('interest_type')->nullable(); // e.g., 'declining balance', 'flat rate', etc.
            $table->boolean('is_interest_percentage')->default(true); // true = %, false = fixed amount
            $table->enum('interest_period', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->decimal('minimum_interest', 15, 2)->nullable();
            $table->decimal('default_interest', 15, 2)->nullable();
            $table->decimal('maximum_interest', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            $table->dropColumn([
                'interest_method',
                'interest_type',
                'is_interest_percentage',
                'interest_period',
                'minimum_interest',
                'default_interest',
                'maximum_interest',
            ]);
        });
    }
};
