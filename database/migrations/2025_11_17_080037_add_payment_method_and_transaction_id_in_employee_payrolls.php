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
        Schema::table('employee_payrolls', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->default("كاش");
            $table->bigInteger('transaction_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_payrolls', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('transaction_id');
        });
    }
};
