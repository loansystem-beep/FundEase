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
        Schema::table('bank_accounts', function (Blueprint $table) {
            // Add columns only if they don't already exist
            if (!Schema::hasColumn('bank_accounts', 'currency')) {
                $table->string('currency', 3)->nullable();
            }
            if (!Schema::hasColumn('bank_accounts', 'balance')) {
                $table->decimal('balance', 15, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn(['currency', 'balance']);
        });
    }
};
