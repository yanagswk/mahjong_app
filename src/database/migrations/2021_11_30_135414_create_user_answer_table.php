<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answer', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('回答者');
            $table->integer('mahjong_problem_id')->unsigned()->nullable()->comment('問題');
            $table->integer('select_tile')->unsigned()->comment('回答者が選択した牌');
            $table->string('comment')->nullable()->comment('回答者のコメント');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('mahjong_problem_id')->references('id')->on('mahjong_problem')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('select_tile')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answer');
    }
}
