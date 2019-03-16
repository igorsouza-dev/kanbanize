<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->string('title');
            $table->string('description');
            $table->string('color');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('column_id');
            $table->date('deadline');
            $table->unsignedInteger('column_position');
            $table->tinyInteger('type');
            $table->tinyInteger('priority');
            $table->tinyInteger('size');//fibonacci card size - difficulty

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('column_id')->references('id')->on('columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
