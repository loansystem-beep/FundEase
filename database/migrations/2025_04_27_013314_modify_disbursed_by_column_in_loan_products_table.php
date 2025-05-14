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
            // Safely modify 'disbursed_by' to allow 255 characters and make it nullable to avoid truncation errors
            $table->string('disbursed_by', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            // Revert 'disbursed_by' back to 100 characters and nullable
            $table->string('disbursed_by', 100)->nullable()->change();
        });
    }
};
