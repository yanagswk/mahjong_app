<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahjongProblemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahjong_problem', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('問題作成者');
            $table->integer('problem_tiles1')->unsigned()->comment('問題の牌1');
            $table->integer('problem_tiles2')->unsigned()->comment('問題の牌2');
            $table->integer('problem_tiles3')->unsigned()->comment('問題の牌3');
            $table->integer('problem_tiles4')->unsigned()->comment('問題の牌4');
            $table->integer('problem_tiles5')->unsigned()->comment('問題の牌5');
            $table->integer('problem_tiles6')->unsigned()->comment('問題の牌6');
            $table->integer('problem_tiles7')->unsigned()->comment('問題の牌7');
            $table->integer('problem_tiles8')->unsigned()->comment('問題の牌8');
            $table->integer('problem_tiles9')->unsigned()->comment('問題の牌9');
            $table->integer('problem_tiles10')->unsigned()->comment('問題の牌10');
            $table->integer('problem_tiles11')->unsigned()->comment('問題の牌11');
            $table->integer('problem_tiles12')->unsigned()->comment('問題の牌12');
            $table->integer('problem_tiles13')->unsigned()->comment('問題の牌13');
            $table->string('problem_description')->nullable()->comment('問題の説明');
            $table->integer('station_id')->unsigned()->nullable()->comment('局 (東1局、南2局など)');
            $table->integer('direction_id')->unsigned()->nullable()->comment('自風 (東家、南家など)');
            $table->integer('round')->nullable()->comment('巡目');
            $table->integer('dora')->unsigned()->nullable()->comment('ドラ牌');
            $table->integer('have_point')->nullable()->comment('持ち点');
            $table->integer('answer1')->unsigned()->comment('答えの牌1');
            $table->integer('answer2')->unsigned()->comment('答えの牌2');
            $table->string('description')->nullable()->comment('答えの説明');
            $table->boolean('publish')->comment('公開するか');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles1')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles2')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles3')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles4')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles5')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles6')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles7')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles8')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles9')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles10')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles11')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles12')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('problem_tiles13')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('station_id')->references('id')->on('station_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('direction_id')->references('id')->on('direction_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('dora')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('answer1')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('answer2')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahjong_problem');
    }
}

