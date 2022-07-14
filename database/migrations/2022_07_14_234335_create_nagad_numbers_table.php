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
        Schema::create('nagad_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('mobile')->nullable();
            $table->string('package_name')->nullable();
            $table->string('android_title')->nullable();
            $table->string('android_text')->nullable();
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
        Schema::dropIfExists('nagad_numbers');
    }
};
