<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loan_product_fee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_product_fee');
    }
};
