<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            // New: Loan Title and Description
            $table->string('loan_title')->nullable();
            $table->text('description')->nullable();

            // Basic Info
            $table->unsignedBigInteger('loan_product_id');
            $table->unsignedBigInteger('borrower_id');
            $table->string('loan_number')->unique();
            $table->unsignedBigInteger('loan_status_id')->nullable();

            // Principal Info
            $table->unsignedBigInteger('disbursed_by_id')->nullable();
            $table->decimal('principal_amount', 15, 2);
            $table->date('loan_release_date')->nullable();

            // Interest Info
            $table->string('interest_method')->nullable();
            $table->string('interest_type')->nullable();
            $table->decimal('interest_rate', 8, 4)->nullable();
            $table->string('interest_period')->nullable();

            // Duration Info
            $table->integer('loan_duration_value')->nullable();
            $table->string('loan_duration_type')->nullable();

            // Repayment Info
            $table->unsignedBigInteger('repayment_cycle_id')->nullable();
            $table->integer('number_of_repayments')->nullable();

            // Advanced Settings
            $table->integer('decimal_places')->nullable();
            $table->boolean('round_up_off_interest')->default(false);
            $table->date('interest_start_date')->nullable();
            $table->date('first_repayment_date')->nullable();
            $table->boolean('pro_rata_first_repayment')->default(false);
            $table->boolean('adjust_fees_first_repayment')->default(false);
            $table->boolean('do_not_adjust_remaining_repayments')->default(false);
            $table->decimal('first_repayment_amount', 15, 2)->nullable();
            $table->decimal('last_repayment_amount', 15, 2)->nullable();
            $table->date('override_maturity_date')->nullable();
            $table->decimal('override_each_repayment_amount', 15, 2)->nullable();
            $table->boolean('calculate_interest_pro_rata')->default(false);
            $table->enum('interest_charge_method', ['normal', 'balloon'])->nullable();
            $table->enum('principal_charge_method', ['normal', 'balloon'])->nullable();
            $table->decimal('balloon_repayment_amount', 15, 2)->nullable();
            $table->integer('move_first_repayment_days')->nullable();

            // Automatic Payments
            $table->boolean('automatic_payments')->default(false);
            $table->time('automatic_payment_start_time')->nullable();
            $table->time('automatic_payment_end_time')->nullable();
            $table->enum('payment_method', ['cash', 'bank'])->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();

            // Fee Info
            $table->unsignedBigInteger('fee_id')->nullable();

            // Extend Loan After Maturity
            $table->boolean('extend_loan_after_maturity')->default(false);
            $table->enum('after_maturity_interest_type', ['percentage', 'fixed'])->nullable();
            $table->decimal('after_maturity_interest_rate', 8, 4)->nullable();
            $table->string('after_maturity_interest_period')->nullable();
            $table->integer('after_maturity_number_of_repayments')->nullable();
            $table->boolean('include_fees_after_maturity')->default(false);
            $table->boolean('keep_status_as_past_maturity')->default(false);
            $table->date('apply_to_date')->nullable();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('loan_product_id')->references('id')->on('loan_products')->onDelete('cascade');
            $table->foreign('borrower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('loan_status_id')->references('id')->on('loan_statuses')->onDelete('set null');
            $table->foreign('disbursed_by_id')->references('id')->on('bank_accounts')->onDelete('set null');
            $table->foreign('repayment_cycle_id')->references('id')->on('repayment_cycles')->onDelete('set null');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('set null');
        });

        // Loan Files Table
        Schema::create('loan_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_files');
        Schema::dropIfExists('loans');
    }
};
