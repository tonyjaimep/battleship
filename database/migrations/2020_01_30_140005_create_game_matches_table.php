<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('finished_at')->nullable();
            $table->string('user_a_id');
            $table->string('user_b_id')->nullable();
            $table->string('winner_id')->nullable();
            $table->string('state')->nullable();

            $table->string('turn')->nullable();

            $table->foreign('user_a_id')->references('id')->on('sessions');
            $table->foreign('user_b_id')->references('id')->on('sessions');
            $table->foreign('winner_id')->references('id')->on('sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_matches');
    }
}
