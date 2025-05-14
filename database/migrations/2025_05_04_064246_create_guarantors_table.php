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
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();

            // Required field
            $table->string('country')->default('Kenya');

            // Name fields
            $table->string('first_name')->nullable();
            $table->string('middle_last_name')->nullable();
            $table->string('business_name')->nullable();

            // Optional fields
            $table->string('unique_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('title')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('landline')->nullable();
            $table->string('working_status')->nullable();
            $table->string('photo_path')->nullable();
            $table->text('description')->nullable();

            // Loan officer (user) relationship
            $table->unsignedBigInteger('loan_officer_id')->nullable();
            $table->foreign('loan_officer_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guarantors');
    }
};
