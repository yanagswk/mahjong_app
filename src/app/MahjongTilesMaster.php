<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahjongTilesMaster extends Model
{
    /** テーブル名 */
    protected $table = 'mahjong_tiles_master';

    /** タイムスタンプを更新しない */
    public $timestamps = false;

    protected $fillable = [
        'mahjong_tiles'
    ];
}
