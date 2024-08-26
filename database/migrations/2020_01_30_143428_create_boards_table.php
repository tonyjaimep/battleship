<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('game_match_id');
            $table->string('user_id')->nullable();
            $table->unsignedInteger('size')->default(10);

            $table->foreign('game_match_id')->references('id')->on('game_matches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
