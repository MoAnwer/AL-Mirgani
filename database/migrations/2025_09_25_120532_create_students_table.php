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
            $table->string('student_number')->unique();
            $table->string('address')->nullable();
            $table->foreignId('class_id')->constrained('classes')->onDelete('SET NULL')->nullable();
            $table->foreignId('father_id')->constrained('fathers')->onDelete('SET NULL')->nullable();
            $table->foreignId('school_id')->constrained('schools')->onDelete('SET NULL')->nullable();
            $table->string('stage');
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
