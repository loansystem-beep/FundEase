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
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_product_id')->constrained()->onDelete('cascade'); // Foreign key to loan_products
            $table->decimal('amount', 15, 2);  // Amount for the repayment
            $table->date('due_date'); // Repayment due date
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending'); // Repayment status
            $table->timestamp('payment_date')->nullable(); // Timestamp for when the repayment was made
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_repayments');
    }
};
