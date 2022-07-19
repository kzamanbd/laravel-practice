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
            $table->string('app_name')->nullable();
            $table->string('package_name')->nullable();
            $table->string('android_title')->nullable();
            $table->string('android_text')->nullable();
            $table->string('android_sub_text')->nullable();
            $table->string('android_big_text')->nullable();
            $table->string('android_info_text')->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->tinyInteger('is_offline')->nullable();
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
