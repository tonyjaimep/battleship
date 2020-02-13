<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attacks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('created_at');
            $table->string('user_id');
            $table->unsignedBigInteger('target_board_id');
            $table->unsignedInteger('target_x');
            $table->unsignedInteger('target_y');
            $table->boolean('hit')->nullable();

            $table->foreign('user_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('target_board_id')->references('id')->on('boards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attacks');
    }
}
