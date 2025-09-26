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
        Schema::create('registration_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('SET NULL');
            $table->decimal('amount', 15)->default(0);
            $table->decimal('paid_amount', 15)->default(0)->nullable();
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->default(null)->nullable();
            $table->integer('transaction_id')->default(null)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_fees');
    }
};
