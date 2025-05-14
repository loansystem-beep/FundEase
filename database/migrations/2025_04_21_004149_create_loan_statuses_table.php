<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loan_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // e.g., Processing, Open, Defaulted, Denied, Not Taken Up
            $table->integer('position')->default(0); // For drag-and-drop reordering
            $table->boolean('is_system_generated')->default(false); // Prevent editing for core statuses
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_statuses');
    }
};
