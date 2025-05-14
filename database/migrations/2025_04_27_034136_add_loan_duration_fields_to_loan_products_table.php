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
            $table->enum('loan_duration_period', ['days', 'months', 'years'])->nullable()->after('maximum_principal_amount');
            $table->integer('minimum_loan_duration')->nullable()->after('loan_duration_period');
            $table->integer('default_loan_duration')->nullable()->after('minimum_loan_duration');
            $table->integer('maximum_loan_duration')->nullable()->after('default_loan_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            $table->dropColumn(['loan_duration_period', 'minimum_loan_duration', 'default_loan_duration', 'maximum_loan_duration']);
        });
    }
};
