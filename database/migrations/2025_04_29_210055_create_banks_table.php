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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->length(4); // Bank code (4 digits)
            $table->string('bank_account_name'); // Bank account name
            $table->string('account_name'); // Account holder name
            $table->string('currency')->default('KES'); // Currency (default is KES)
            $table->json('loan_categories')->nullable(); // Categories for loan types (Business, Overseas, etc.)
            $table->json('repayment_categories')->nullable(); // Categories for repayment types
            $table->json('expense_categories')->nullable(); // Expense categories
            $table->json('income_categories')->nullable(); // Other income categories
            $table->json('transaction_categories')->nullable(); // Savings & Investor transaction categories
            $table->json('branch_capital_categories')->nullable(); // Branch capital categories
            $table->json('payroll_categories')->nullable(); // Payroll categories
            $table->json('branches')->nullable(); // Branches that have access to this bank
            $table->boolean('is_default')->default(false); // Whether this is the default bank account
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
