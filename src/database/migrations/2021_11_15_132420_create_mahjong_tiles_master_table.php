<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahjongTilesMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahjong_tiles_master', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('tiles_group_id')->unsigned()->nullable()->comment('牌のグループ');
            $table->string('tiles_name')->unique()->comment('牌の名前');
            $table->string('mahjong_tiles')->unique()->comment('牌の画像URL');

            $table->foreign('tiles_group_id')->references('id')->on('tiles_group_master')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahjong_tiles_master');
    }
}
