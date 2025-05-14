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
        Schema::create('repayment_cycles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Optional: display name of cycle
            $table->enum('type', ['days', 'monthly', 'weekly']); // type of repayment cycle
            $table->integer('every_x_days')->nullable(); // only used if type is days
            $table->json('monthly_dates')->nullable(); // only used if type is monthly
            $table->json('weekly_days')->nullable(); // only used if type is weekly
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayment_cycles');
    }
};
