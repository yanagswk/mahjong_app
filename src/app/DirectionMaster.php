<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectionMaster extends Model
{
    /** テーブル名 */
    protected $table = 'direction_master';

    /** タイムスタンプを更新しない */
    public $timestamps = false;

    protected $fillable = [
        'direction'
    ];
}
