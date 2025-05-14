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
            // Add the 'user_id' column
            $table->unsignedBigInteger('user_id')->nullable()->after('borrower_id');

            // Add the foreign key relationship with the 'users' table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Drop the foreign key and the 'user_id' column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
