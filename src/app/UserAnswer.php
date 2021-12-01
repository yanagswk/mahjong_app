<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    /** テーブル名 */
    protected $table = 'user_answer';

    protected $fillable = [
        'user_id',
        'mahjong_problem_id',
        'select_tile',
        'comment',
    ];
}
