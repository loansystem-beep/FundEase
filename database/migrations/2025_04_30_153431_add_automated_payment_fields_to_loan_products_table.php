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
        // Schema::table('loan_products', function (Blueprint $table) {
        //     $table->boolean('auto_payments_enabled')->nullable()->after('keep_past_maturity_status');
        //     $table->time('start_time')->nullable()->after('auto_payments_enabled');
        //     $table->time('end_time')->nullable()->after('start_time');
        //     $table->string('payment_method')->nullable()->after('end_time');
        //     $table->unsignedBigInteger('bank_account_id')->nullable()->after('payment_method');
        //     $table->string('custom_time_range')->nullable()->after('bank_account_id');

        //     // Foreign key constraint (optional but good practice)
        //     $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('loan_products', function (Blueprint $table) {
        //     $table->dropForeign(['bank_account_id']); // Drop foreign key constraint
        //     $table->dropColumn([
        //         'auto_payments_enabled',
        //         'start_time',
        //         'end_time',
        //         'payment_method',
        //         'bank_account_id',
        //         'custom_time_range',
        //     ]);
        // });
    }
};
