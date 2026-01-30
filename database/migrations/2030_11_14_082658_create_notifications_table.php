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
        if (!file_exists(database_path('notifications.sqlite'))) {
            // Create new sqlite database file
            touch(database_path('notifications.sqlite'));
        }

        // Create notifications table if not exists
        if (! Schema::connection('notifications')->hasTable('notifications')) {
            Schema::connection('notifications')->create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('notifications')->dropIfExists('notifications');
    }
};
