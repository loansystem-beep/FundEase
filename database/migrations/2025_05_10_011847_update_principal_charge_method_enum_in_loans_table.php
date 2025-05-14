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
        Schema::table('loans', function (Blueprint $table) {
            $table->enum('principal_charge_method', [
                'normal',
                'released_date',
                'first_repayment',
                'last_repayment',
                'do_not_charge_last_repayment',
                'do_not_charge_first_n_days',
            ])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->string('principal_charge_method')->nullable()->change();
        });
    }
};
