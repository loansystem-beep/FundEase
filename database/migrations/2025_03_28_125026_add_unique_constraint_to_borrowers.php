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
        Schema::table('borrowers', function (Blueprint $table) {
            // Ensure the phone_number column exists before adding it
            if (!Schema::hasColumn('borrowers', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            if (Schema::hasColumn('borrowers', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};
