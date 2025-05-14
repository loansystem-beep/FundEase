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
            // Adding principal amount fields
            $table->decimal('minimum_principal_amount', 15, 2)->nullable()->after('name'); // Replace 'name' with the column where you want to add the new fields after
            $table->decimal('default_principal_amount', 15, 2)->nullable()->after('minimum_principal_amount');
            $table->decimal('maximum_principal_amount', 15, 2)->nullable()->after('default_principal_amount');

            // Adding disbursement method field
            $table->enum('disbursed_by', ['cash', 'cheque', 'wire_transfer', 'online_transfer'])->nullable()->after('maximum_principal_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            // Dropping the newly added columns
            $table->dropColumn([
                'minimum_principal_amount',
                'default_principal_amount',
                'maximum_principal_amount',
                'disbursed_by'
            ]);
        });
    }
};
