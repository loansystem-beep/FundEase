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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id()->unsigned(); // Ensure the ID is unsigned
            $table->string('name'); // Name of the bank account
            $table->string('account_number')->nullable(); // Account number (optional)
            $table->string('bank_name')->nullable(); // Name of the bank (optional)
            $table->string('branch')->nullable(); // Branch of the bank (optional)
            $table->string('swift_code')->nullable(); // SWIFT code for international transactions (optional)
            $table->boolean('is_active')->default(true); // Active status for the bank account
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
