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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('employee_payrolls')->onDelete('set null'); 
            $table->foreignId('item_id')->constrained('payroll_items')->onDelete('restrict');             
            $table->decimal('amount', 10, 2);            
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['payroll_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};