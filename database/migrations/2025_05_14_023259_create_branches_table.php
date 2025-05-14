<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Branch name
            $table->string('code')->unique()->nullable(); // Branch code (unique)
            $table->string('location')->nullable(); // Branch location (optional)
            $table->string('currency')->nullable(); // Override: Branch currency
            $table->string('country')->nullable(); // Override: Branch country
            $table->string('date_format')->nullable(); // Override: Date format (e.g. d/m/Y)
            $table->text('address')->nullable(); // Full address
            $table->string('phone')->nullable(); // Contact number
            $table->string('email')->nullable(); // Contact email
            $table->text('description')->nullable(); // Additional info/notes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
