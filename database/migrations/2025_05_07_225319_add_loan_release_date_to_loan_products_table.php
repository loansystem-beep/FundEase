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
            // Adding the auto_payments_enabled column after the maximum_number_of_repayments column
            $table->boolean('auto_payments_enabled')->default(false)->after('maximum_number_of_repayments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            // Dropping the auto_payments_enabled column
            $table->dropColumn('auto_payments_enabled');
        });
    }
};
