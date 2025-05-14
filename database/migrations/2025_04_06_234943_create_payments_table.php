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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key to users table
            $table->decimal('amount', 10, 2);  // Store the payment amount
            $table->string('status');  // Payment status (e.g., 'pending', 'completed')
            $table->timestamp('paid_at')->nullable();  // Timestamp of payment
            $table->string('mpesa_number')->nullable();  // MPesa number
            $table->string('mpesa_transaction_code')->nullable();  // MPesa transaction code
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
