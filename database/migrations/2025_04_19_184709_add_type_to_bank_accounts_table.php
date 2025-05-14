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
        Schema::table('bank_accounts', function (Blueprint $table) {
            // Add 'type' column if it does not exist
            if (!Schema::hasColumn('bank_accounts', 'type')) {
                $table->string('type')->nullable(); // Adjust the type if needed
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            // Drop 'type' column if it exists
            if (Schema::hasColumn('bank_accounts', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
