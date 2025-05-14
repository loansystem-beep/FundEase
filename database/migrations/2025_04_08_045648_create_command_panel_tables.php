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
        // Creating the table for the command panel feature
        Schema::create('command_panels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // User who will manage
            $table->boolean('is_active')->default(true);  // Command panel feature active or inactive
            $table->timestamps();
        });

        // Table for user messages (Chat functionality)
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');  // Sender
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');  // Receiver
            $table->text('message');
            $table->timestamps();
        });

        // Updates for user status in the 'users' table to track activation status
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);  // To manage active or inactive users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');  // Remove the is_active column if rolling back
        });

        Schema::dropIfExists('messages');  // Drop messages table
        Schema::dropIfExists('command_panels');  // Drop the command panel table
    }
};
