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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('e_tin');
            $table->string('old_tin')->nullable();
            $table->string('tin_date')->nullable();
            $table->string('asses_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('police_station')->nullable();
            $table->string('circle_name')->nullable();
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
        Schema::dropIfExists('contacts');
    }
};
