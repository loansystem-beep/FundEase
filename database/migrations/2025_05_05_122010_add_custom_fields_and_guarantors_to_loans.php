<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add fields to existing 'loans' table
        Schema::table('loans', function (Blueprint $table) {
            $table->boolean('is_custom_loan_number')->default(false)->after('loan_number');
            $table->unsignedBigInteger('deductible_fee_id')->nullable()->after('fee_id');
            $table->unsignedBigInteger('non_deductible_fee_id')->nullable()->after('deductible_fee_id');
            $table->json('custom_fields')->nullable()->after('description');
        });

        // Add foreign keys for the new fees
        Schema::table('loans', function (Blueprint $table) {
            $table->foreign('deductible_fee_id')->references('id')->on('fees')->onDelete('set null');
            $table->foreign('non_deductible_fee_id')->references('id')->on('fees')->onDelete('set null');
        });

        // Create pivot table for loan_guarantor
        Schema::create('guarantor_loan', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('guarantor_id');
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('guarantor_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['loan_id', 'guarantor_id']);
        });
    }

    public function down(): void
    {
        // Drop foreign keys first to avoid constraint errors
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['deductible_fee_id']);
            $table->dropForeign(['non_deductible_fee_id']);
            $table->dropColumn(['is_custom_loan_number', 'deductible_fee_id', 'non_deductible_fee_id', 'custom_fields']);
        });

        Schema::dropIfExists('guarantor_loan');
    }
};
