<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to associate with the user
            $table->string('borrower_type')->default('individual'); // Individual or Business
            $table->string('first_name'); // First name of the borrower
            $table->string('last_name'); // Last name of the borrower
            $table->string('business_name')->nullable(); // Optional for businesses
            $table->date('date_of_birth')->nullable(); // Date of birth
            $table->string('email'); // Email (no global uniqueness)
            $table->string('phone_number')->nullable(); // Optional phone number
            $table->string('gender')->nullable(); // Male/Female
            $table->string('title')->nullable(); // Mr, Mrs, Dr, etc.
            $table->text('description')->nullable(); // Additional info
            $table->text('address')->nullable(); // Address
            $table->json('custom_fields')->nullable(); // Custom fields
            $table->timestamps(); // Created at and updated at timestamps

            // Add foreign key constraint (optional, but recommended)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Ensure email is unique per user (same email for different users is allowed)
            $table->unique(['email', 'user_id']); // Unique combination of email and user_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowers');
    }
}
