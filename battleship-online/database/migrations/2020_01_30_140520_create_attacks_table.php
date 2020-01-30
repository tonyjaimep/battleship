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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('target_board_id');
            $table->unsigned('target_x');
            $table->unsigned('target_y');
            $table->boolean('hit')->nullable();
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
