<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('article_id');
            $table->string('title');
            $table->text('content');
            $table->integer('rating');

            $table->bigInteger('author_id')->unsigned();
            $table->foreign('author_id')->on('users')->references('user_id')->onDelete('cascade');


            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->on('categories')->references('category_id')->onDelete('cascade');

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
        Schema::dropIfExists('articles');
    }
}
