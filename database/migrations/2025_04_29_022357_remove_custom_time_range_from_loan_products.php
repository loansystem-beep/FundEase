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
        // Schema::table('loan_products', function (Blueprint $table) {
        //     // Remove the custom_time_range column
        //     $table->dropColumn('custom_time_range');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('loan_products', function (Blueprint $table) {
        //     // Restore the custom_time_range column in case of rollback
        //     $table->string('custom_time_range')->nullable(); // Custom time range for automatic payments
        // });
    }
};
