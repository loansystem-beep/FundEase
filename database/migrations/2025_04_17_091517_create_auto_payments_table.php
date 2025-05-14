<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Temporarily commented out due to dependency on loans table
        // Schema::create('auto_payments', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('loan_id')->constrained()->onDelete('cascade');
        //     $table->boolean('enabled')->default(false);
        //     $table->time('time_start')->nullable();
        //     $table->time('time_end')->nullable();
        //     $table->enum('account_type', ['cash', 'bank'])->default('cash');
        //     $table->string('account_name')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Temporarily commented out
        // Schema::dropIfExists('auto_payments');
    }
};
