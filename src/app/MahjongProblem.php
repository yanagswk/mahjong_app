<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahjongProblem extends Model
{
    /** テーブル名 */
    protected $table = 'mahjong_problem';

    protected $fillable = [
        'user_id',
        'problem_image_url',
        'problem_description',
        'station_id',
        'direction_id',
        'round',
        'dora',
        'have_point',
        'answer',
        'answer_description',
        'disabled',
    ];
}
