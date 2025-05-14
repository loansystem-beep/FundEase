<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::table('loan_products', function (Blueprint $table) {
        //     // First drop the foreign key constraint
        //     $table->dropForeign(['bank_account_id']);

        //     // Then drop the columns
        //     $table->dropColumn([
        //         'auto_payments_enabled',
        //         'payment_method',
        //         'bank_account_id',
        //         'start_time',
        //         'end_time',
        //         'custom_time_range',
        //     ]);
        // });
    }

    public function down(): void
    {
        // Schema::table('loan_products', function (Blueprint $table) {
        //     $table->boolean('auto_payments_enabled')->nullable();
        //     $table->string('payment_method')->nullable();
        //     $table->unsignedBigInteger('bank_account_id')->nullable();
        //     $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
        //     $table->string('start_time')->nullable();
        //     $table->string('end_time')->nullable();
        //     $table->string('custom_time_range')->nullable();
        // });
    }
};
