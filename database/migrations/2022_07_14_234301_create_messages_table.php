<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('android_title')->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->string('android_text')->nullable();
            $table->string('msg_from')->nullable();
            $table->string('sender')->nullable();
            $table->tinyInteger('is_offline')->nullable();
            $table->string('status')->nullable()
                ->default('PENDING')
                ->comment('PENDING, APPROVED, REJECT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
