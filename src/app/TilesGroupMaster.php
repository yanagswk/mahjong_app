<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TilesGroupMaster extends Model
{
    /** テーブル名 */
    protected $table = 'tiles_group_master';

    /** タイムスタンプを更新しない */
    public $timestamps = false;

    protected $fillable = [
        'tiles_group_name'
    ];
}
