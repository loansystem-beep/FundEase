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
            // Add the calculated_interest column to store the calculated interest amount
            $table->decimal('calculated_interest', 15, 2)->nullable()->after('interest_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Drop the calculated_interest column if the migration is rolled back
            $table->dropColumn('calculated_interest');
        });
    }
};
