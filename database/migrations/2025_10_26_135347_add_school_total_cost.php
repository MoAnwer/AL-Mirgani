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
        Schema::table('employee_payrolls', function(Blueprint $table) {
            $table->decimal('school_total_cost', 15, 2)->nullable()->default(0)->after('net_salary_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payrolls', function(Blueprint $table) {
            $table->dropColumn('school_total_cost');
        });
    }
};
