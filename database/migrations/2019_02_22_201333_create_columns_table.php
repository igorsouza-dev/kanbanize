<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('board_id');
            $table->unsignedInteger('board_position');
            $table->unsignedInteger('parent_column_id')->nullable();
            $table->string('name');
            $table->unsignedInteger('max_cards');

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('board_id')->references('id')->on('boards');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
}
