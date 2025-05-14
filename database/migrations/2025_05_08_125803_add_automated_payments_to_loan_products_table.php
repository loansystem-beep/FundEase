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
        Schema::table('loan_products', function (Blueprint $table) {
            if (!Schema::hasColumn('loan_products', 'auto_payments_enabled')) {
                $table->boolean('auto_payments_enabled')->default(0)->after('maximum_number_of_repayments');
            }

            if (!Schema::hasColumn('loan_products', 'start_time')) {
                $table->time('start_time')->nullable()->after('auto_payments_enabled');
            }

            if (!Schema::hasColumn('loan_products', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }

            if (!Schema::hasColumn('loan_products', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('end_time');
            }

            if (!Schema::hasColumn('loan_products', 'bank_account_id')) {
                $table->unsignedBigInteger('bank_account_id')->nullable()->after('payment_method');
                // $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_products', function (Blueprint $table) {
            if (Schema::hasColumn('loan_products', 'auto_payments_enabled')) {
                $table->dropColumn('auto_payments_enabled');
            }

            if (Schema::hasColumn('loan_products', 'start_time')) {
                $table->dropColumn('start_time');
            }

            if (Schema::hasColumn('loan_products', 'end_time')) {
                $table->dropColumn('end_time');
            }

            if (Schema::hasColumn('loan_products', 'payment_method')) {
                $table->dropColumn('payment_method');
            }

            if (Schema::hasColumn('loan_products', 'bank_account_id')) {
                $table->dropColumn('bank_account_id');
            }
        });
    }
};
