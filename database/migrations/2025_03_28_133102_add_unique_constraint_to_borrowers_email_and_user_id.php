<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the unique constraint already exists
        if (!Schema::hasTable('borrowers') || DB::table('information_schema.key_column_usage')
            ->where('table_name', 'borrowers')
            ->where('constraint_name', 'borrowers_email_user_id_unique')
            ->exists()) {
            return; // Constraint already exists, no need to add it again
        }

        // Add composite unique constraint on email and user_id
        Schema::table('borrowers', function (Blueprint $table) {
            $table->unique(['email', 'user_id']); // Composite unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique(['email', 'user_id']); // Drop the unique constraint
        });
    }
};
