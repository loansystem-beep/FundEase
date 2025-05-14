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
        Schema::table('loans', function (Blueprint $table) {
            // Add the `amount` column, same type as `principal_amount`
            $table->decimal('amount', 15, 2)->nullable(); // Adjust based on whether it should allow null or not
        });

        // Optionally populate the `amount` column with the value of `principal_amount`
        DB::table('loans')->update(['amount' => DB::raw('principal_amount')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Remove the `amount` column in case of rollback
            $table->dropColumn('amount');
        });
    }
};
