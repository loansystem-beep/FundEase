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
        // Create the 'notifications' table with relevant columns
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to 'users' table
            $table->string('type'); // Type of notification (e.g., 'loan_due', 'repayment_received')
            $table->text('message'); // The message content of the notification
            $table->boolean('read')->default(false); // Whether the notification has been read
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'notifications' table if the migration is rolled back
        Schema::dropIfExists('notifications');
    }
};
