<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StationMaster extends Model
{
    /** テーブル名 */
    protected $table = 'station_master';

    /** タイムスタンプを更新しない */
    public $timestamps = false;

    protected $fillable = [
        'station'
    ];
}
