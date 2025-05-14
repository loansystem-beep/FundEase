<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees', function (Blueprint $table) {
            if (!Schema::hasColumn('fees', 'fee_type')) {
                $table->enum('fee_type', ['deductible', 'non_deductible'])->after('name');
            }

            if (!Schema::hasColumn('fees', 'calculation_method')) {
                $table->enum('calculation_method', ['fixed', 'percentage'])->after('fee_type');
            }

            if (!Schema::hasColumn('fees', 'calculation_target')) {
                $table->enum('calculation_target', ['principal', 'interest', 'both'])->after('calculation_method');
            }

            if (!Schema::hasColumn('fees', 'amount')) {
                $table->decimal('amount', 15, 2)->after('calculation_target');
            }

            if (!Schema::hasColumn('fees', 'accounting_type')) {
                $table->enum('accounting_type', ['accrual', 'cash'])->after('amount');
            }

            if (!Schema::hasColumn('fees', 'revenue_type')) {
                $table->enum('revenue_type', ['revenue', 'payable'])->after('accounting_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees', function (Blueprint $table) {
            if (Schema::hasColumn('fees', 'fee_type')) {
                $table->dropColumn('fee_type');
            }

            if (Schema::hasColumn('fees', 'calculation_method')) {
                $table->dropColumn('calculation_method');
            }

            if (Schema::hasColumn('fees', 'calculation_target')) {
                $table->dropColumn('calculation_target');
            }

            if (Schema::hasColumn('fees', 'amount')) {
                $table->dropColumn('amount');
            }

            if (Schema::hasColumn('fees', 'accounting_type')) {
                $table->dropColumn('accounting_type');
            }

            if (Schema::hasColumn('fees', 'revenue_type')) {
                $table->dropColumn('revenue_type');
            }
        });
    }
}
