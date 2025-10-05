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
        Schema::create('installment_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_id')->constrained('installments')->onDelete('set null');
            $table->foreignId('student_id')->constrained('students')->onDelete('set null');
            $table->decimal('paid_amount', 15)->nullable();
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {                                                                                                                                                               
        Schema::dropIfExists('installment_payments');
    }
};
