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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('from_user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('to_user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('last_msg_id')
                ->nullable()
                ->constrained('messages')
                ->onDelete('cascade');
            $table->string('msg_type')
                ->default('single')
                ->comment('group, single');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
