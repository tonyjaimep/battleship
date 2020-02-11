<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('finished_at')->nullable();
            $table->unsignedBigInteger('user_a_id');
            $table->unsignedBigInteger('user_b_id')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->string('state')->nullable();

            $table->foreign('user_a_id')->references('id')->on('users');
            $table->foreign('user_b_id')->references('id')->on('users');
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
