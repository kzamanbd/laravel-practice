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
        Schema::create('message_notifiers', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('package_name');
            $table->string('android_title');
            $table->string('android_text');
            $table->string('android_sub_text');
            $table->string('android_big_text');
            $table->string('android_info_text');
            $table->string('transaction_id');
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
        Schema::dropIfExists('message_notifiers');
    }
};
