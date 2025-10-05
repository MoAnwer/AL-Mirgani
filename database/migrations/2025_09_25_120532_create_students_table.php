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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->integer('student_number')->unique();
            $table->string('address')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->foreignId('father_id')->nullable()->constrained('fathers')->onDelete('set null');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            $table->string('stage');
            $table->integer('discount')->nullable()->default(0);
            $table->decimal('total_fee', 10)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
