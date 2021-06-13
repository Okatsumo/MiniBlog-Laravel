<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id('vote_id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('user_id')->onDelete('cascade');

            $table->bigInteger('article_id')->unsigned();
            $table->foreign('article_id')->on('articles')->references('article_id')->onDelete('cascade');

            $table->integer('point');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
