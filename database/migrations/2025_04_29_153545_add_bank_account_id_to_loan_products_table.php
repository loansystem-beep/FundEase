<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_account_id')->nullable()->after('custom_time_range');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('loan_products', 'bank_account_id')) {
            // Drop the foreign key safely using raw SQL
            try {
                DB::statement('ALTER TABLE loan_products DROP FOREIGN KEY loan_products_bank_account_id_foreign');
            } catch (\Throwable $e) {
                // Foreign key might not exist — ignore the error
            }

            Schema::table('loan_products', function (Blueprint $table) {
                $table->dropColumn('bank_account_id');
            });
        }
    }
};
