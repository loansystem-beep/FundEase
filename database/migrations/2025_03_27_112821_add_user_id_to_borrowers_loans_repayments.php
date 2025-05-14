<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            if (!Schema::hasColumn('borrowers', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
        });

        // Commented out for now - loans table doesn't exist yet
        // Schema::table('loans', function (Blueprint $table) {
        //     if (!Schema::hasColumn('loans', 'user_id')) {
        //         $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        //     }
        // });

        // Commented out for now - repayments table doesn't exist yet
        // Schema::table('repayments', function (Blueprint $table) {
        //     if (!Schema::hasColumn('repayments', 'user_id')) {
        //         $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowers', function (Blueprint $table) {
            if (Schema::hasColumn('borrowers', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });

        // Schema::table('loans', function (Blueprint $table) {
        //     if (Schema::hasColumn('loans', 'user_id')) {
        //         $table->dropForeign(['user_id']);
        //         $table->dropColumn('user_id');
        //     }
        // });

        // Schema::table('repayments', function (Blueprint $table) {
        //     if (Schema::hasColumn('repayments', 'user_id')) {
        //         $table->dropForeign(['user_id']);
        //         $table->dropColumn('user_id');
        //     }
        // });
    }
};
