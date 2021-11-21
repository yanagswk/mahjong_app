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
            $table->string('problem_image_url')->comment('問題の画像URL');
            $table->string('problem_description')->nullable()->comment('問題の説明');
            $table->integer('station_id')->unsigned()->nullable()->comment('局 東1局、南2局など)');
            $table->integer('direction_id')->unsigned()->nullable()->comment('自風 (東家、南家など)');
            $table->integer('round')->nullable()->comment('巡目');
            $table->integer('dora')->unsigned()->nullable()->comment('ドラ牌のURLのid');
            $table->integer('have_point')->nullable()->comment('持ち展');
            $table->integer('answer_select_one')->unsigned()->comment('選択する答えの牌の画像URL1');
            $table->integer('answer_select_two')->unsigned()->comment('選択する答えの牌の画像URL2');
            $table->integer('answer_select_three')->unsigned()->comment('選択する答えの牌の画像URL3');
            $table->integer('answer_select_fore')->unsigned()->comment('選択する答えの牌の画像URL4');
            $table->integer('answer_one')->unsigned()->comment('答えの牌の画像URL1');
            $table->integer('answer_two')->unsigned()->comment('答えの牌の画像URL2');
            $table->string('answer_description')->nullable()->comment('答えの説明');
            $table->boolean('publish')->comment('公開するか');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('station_id')->references('id')->on('station_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('direction_id')->references('id')->on('direction_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('dora')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('answer_one')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('answer_two')->references('id')->on('mahjong_tiles_master')->onUpdate('CASCADE')->onDelete('CASCADE');
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

