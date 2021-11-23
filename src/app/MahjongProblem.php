<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MahjongProblem extends Model
{
    /** テーブル名 */
    protected $table = 'mahjong_problem';

    /** JSONに含めない属性 */
    // protected $hidden = [
    //     'answer_select_one', 'answer_select_two', 'answer_select_three'
    // ];

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
        'publish',
    ];

    /**
     * リレーション : station_masterテーブル
     */
    public function station(): HasOne
    {
        return $this->hasOne(StationMaster::class, 'id', 'station_id');
    }

    /**
     * リレーション : direction_masterテーブル
     */
    public function direction(): HasOne
    {
        return $this->hasOne(DirectionMaster::class, 'id', 'direction_id');
    }

    /**
     * スコープ : 麻雀問題リスト取得
     */
    public function scopeProblemList($query)
    {
        return $query->select([
            'mahjong_problem.id',
            'mahjong_problem.user_id',
            'mahjong_problem.problem_image_url',
            'mahjong_problem.problem_description',
            'station_master.station',
            'direction_master.direction',
            'mahjong_problem.round',
            'dora.mahjong_tiles as dora',
            'mahjong_problem.have_point',
            'answer_select_one.mahjong_tiles as answer_select_one',
            'answer_select_two.mahjong_tiles as answer_select_two',
            'answer_select_three.mahjong_tiles as answer_select_three',
            'answer_select_fore.mahjong_tiles as answer_select_fore',
            'answer_select_fore.mahjong_tiles as answer_select_fore',
            'answer_one.mahjong_tiles as answer_one',
            'answer_two.mahjong_tiles as answer_two',
            'mahjong_problem.answer_description'
        ])
        ->join('station_master', 'station_master.id', '=', 'mahjong_problem.station_id')
        ->join('direction_master', 'direction_master.id', '=', 'mahjong_problem.direction_id')
        ->join('mahjong_tiles_master as dora', 'dora.id', 'mahjong_problem.dora')
        ->join('mahjong_tiles_master as answer_select_one', 'answer_select_one.id', 'mahjong_problem.answer_select_one')
        ->join('mahjong_tiles_master as answer_select_two', 'answer_select_two.id', 'mahjong_problem.answer_select_two')
        ->join('mahjong_tiles_master as answer_select_three', 'answer_select_three.id', 'mahjong_problem.answer_select_three')
        ->join('mahjong_tiles_master as answer_select_fore', 'answer_select_fore.id', 'mahjong_problem.answer_select_fore')
        ->join('mahjong_tiles_master as answer_one', 'answer_one.id', 'mahjong_problem.answer_one')
        ->join('mahjong_tiles_master as answer_two', 'answer_two.id', 'mahjong_problem.answer_two');
    }

    /**
     * スコープ : 公開できる問題のみ
     */
    public function scopeActive($query)
    {
        return $query->where('publish', true);
    }
}
