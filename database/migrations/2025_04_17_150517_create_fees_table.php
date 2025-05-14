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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Fee Name
            $table->enum('category', ['deductible', 'non_deductible', 'capitalized']); // Fee Category
            $table->enum('calculation_method', ['fixed', 'percentage']); // Fixed or Percentage
            $table->enum('calculation_base', ['principal', 'interest', 'both'])->nullable(); // What the percentage is based on

            $table->decimal('default_amount', 15, 2)->nullable(); // Default fixed/percentage amount
            
            // Accounting Configuration
            $table->enum('accounting_method', ['accrual', 'cash']); // Accrual or Cash Basis
            $table->enum('accounting_type', ['revenue', 'payable']); // Revenue or Payable
            
            $table->text('description')->nullable(); // Optional description/help text
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
