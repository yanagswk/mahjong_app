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
        'problem_tiles1',
        'problem_tiles2',
        'problem_tiles3',
        'problem_tiles4',
        'problem_tiles5',
        'problem_tiles6',
        'problem_tiles7',
        'problem_tiles8',
        'problem_tiles9',
        'problem_tiles10',
        'problem_tiles11',
        'problem_tiles12',
        'problem_tiles13',
        'problem_description',
        'station_id',
        'direction_id',
        'round',
        'dora',
        'have_point',
        'answer1',
        'answer2',
        'description',
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
            'users.name',
            'problem_tiles1.mahjong_tiles as problem_tiles1',
            'problem_tiles2.mahjong_tiles as problem_tiles2',
            'problem_tiles3.mahjong_tiles as problem_tiles3',
            'problem_tiles4.mahjong_tiles as problem_tiles4',
            'problem_tiles5.mahjong_tiles as problem_tiles5',
            'problem_tiles6.mahjong_tiles as problem_tiles6',
            'problem_tiles7.mahjong_tiles as problem_tiles7',
            'problem_tiles8.mahjong_tiles as problem_tiles8',
            'problem_tiles9.mahjong_tiles as problem_tiles9',
            'problem_tiles10.mahjong_tiles as problem_tiles10',
            'problem_tiles11.mahjong_tiles as problem_tiles11',
            'problem_tiles12.mahjong_tiles as problem_tiles12',
            'problem_tiles13.mahjong_tiles as problem_tiles13',
            'station_master.station',
            'direction_master.direction',
            'mahjong_problem.round',
            'dora.mahjong_tiles as dora',
            'mahjong_problem.have_point',
            'answer1.mahjong_tiles as answer1',
            'answer2.mahjong_tiles as answer2',
            'mahjong_problem.description'
        ])
        ->leftJoin('users', 'users.id', '=', 'mahjong_problem.user_id')
        ->leftJoin('mahjong_tiles_master as problem_tiles1', 'problem_tiles1.id', 'mahjong_problem.problem_tiles1')
        ->leftJoin('mahjong_tiles_master as problem_tiles2', 'problem_tiles2.id', 'mahjong_problem.problem_tiles2')
        ->leftJoin('mahjong_tiles_master as problem_tiles3', 'problem_tiles3.id', 'mahjong_problem.problem_tiles3')
        ->leftJoin('mahjong_tiles_master as problem_tiles4', 'problem_tiles4.id', 'mahjong_problem.problem_tiles4')
        ->leftJoin('mahjong_tiles_master as problem_tiles5', 'problem_tiles5.id', 'mahjong_problem.problem_tiles5')
        ->leftJoin('mahjong_tiles_master as problem_tiles6', 'problem_tiles6.id', 'mahjong_problem.problem_tiles6')
        ->leftJoin('mahjong_tiles_master as problem_tiles7', 'problem_tiles7.id', 'mahjong_problem.problem_tiles7')
        ->leftJoin('mahjong_tiles_master as problem_tiles8', 'problem_tiles8.id', 'mahjong_problem.problem_tiles8')
        ->leftJoin('mahjong_tiles_master as problem_tiles9', 'problem_tiles9.id', 'mahjong_problem.problem_tiles9')
        ->leftJoin('mahjong_tiles_master as problem_tiles10', 'problem_tiles10.id', 'mahjong_problem.problem_tiles10')
        ->leftJoin('mahjong_tiles_master as problem_tiles11', 'problem_tiles11.id', 'mahjong_problem.problem_tiles11')
        ->leftJoin('mahjong_tiles_master as problem_tiles12', 'problem_tiles12.id', 'mahjong_problem.problem_tiles12')
        ->leftJoin('mahjong_tiles_master as problem_tiles13', 'problem_tiles13.id', 'mahjong_problem.problem_tiles13')
        ->leftJoin('station_master', 'station_master.id', '=', 'mahjong_problem.station_id')
        ->leftJoin('direction_master', 'direction_master.id', '=', 'mahjong_problem.direction_id')
        ->leftJoin('mahjong_tiles_master as dora', 'dora.id', 'mahjong_problem.dora')
        ->leftJoin('mahjong_tiles_master as answer1', 'answer1.id', 'mahjong_problem.answer1')
        ->leftJoin('mahjong_tiles_master as answer2', 'answer2.id', 'mahjong_problem.answer2');
    }

    /**
     * スコープ : 公開できる問題のみ
     */
    public function scopeActive($query)
    {
        return $query->where('publish', true);
    }
}
