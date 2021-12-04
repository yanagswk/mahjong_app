<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    /**
     * スコープ : 選択された解答の割合
     */
    public function scopeAnswerRate($query, $problem_id)
    {
        return $query->select(
            'mahjong_tiles_master.mahjong_tiles',
            DB::raw('COUNT(user_answer.select_tile) AS answer_count'),
            DB::raw(
                "round((100.0 * COUNT(user_answer.select_tile) / (
                    SELECT COUNT(user_answer.select_tile)
                    FROM user_answer
                    WHERE user_answer.mahjong_problem_id = {$problem_id}
                )))
                AS 'answer_rate'"
            )
        )
        ->leftJoin('mahjong_tiles_master', 'user_answer.select_tile', 'mahjong_tiles_master.id')
        ->where('mahjong_problem_id', $problem_id)
        ->groupBy('select_tile')
        ->orderBy('answer_rate', 'desc');
    }


    /**
     * スコープ : 指定された問題idの回答を返す
     */
    public function scopeProblemId($query, $problem_id)
    {
        return $query->where('mahjong_problem_id', $problem_id);
    }
}
