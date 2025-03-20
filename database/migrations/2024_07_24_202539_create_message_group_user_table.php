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
        Schema::create('message_group_user', function (Blueprint $table) {
            $table->foreignId('conversation_id')
                ->constrained()->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()->onDelete('cascade');
            $table->foreignId('created_by')
                ->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_group_user');
    }
};
