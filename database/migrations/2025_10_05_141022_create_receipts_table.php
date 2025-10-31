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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->decimal('amount', 15)->nullable();
            $table->foreignId('installment_payment_id')->nullable()->constrained('installment_payments')->onDelete('set null');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->decimal('remanent', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
