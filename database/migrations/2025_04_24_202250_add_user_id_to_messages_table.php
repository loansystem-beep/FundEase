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
        Schema::table('messages', function (Blueprint $table) {
            // Add user_id column and foreign key constraint
            $table->foreignId('user_id')
                  ->after('id') // or adjust this placement as needed
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
