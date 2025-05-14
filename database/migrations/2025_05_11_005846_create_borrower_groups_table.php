<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrower_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->foreignId('group_leader_id')->constrained('borrowers')->onDelete('cascade');
            $table->foreignId('loan_officer_id')->constrained('users')->onDelete('cascade');
            $table->string('collector_name');
            $table->string('meeting_schedule');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrower_groups');
    }
};
