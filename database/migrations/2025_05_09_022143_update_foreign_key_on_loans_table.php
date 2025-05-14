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
            // Drop the existing foreign key (referencing users)
            $table->dropForeign(['borrower_id']);

            // Add the correct foreign key (referencing borrowers)
            $table->foreign('borrower_id')
                ->references('id')
                ->on('borrowers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Drop the foreign key referencing borrowers
            $table->dropForeign(['borrower_id']);

            // Restore the original foreign key (referencing users)
            $table->foreign('borrower_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
