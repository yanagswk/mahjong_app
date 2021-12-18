<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahjongProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {

            if (!DB::table('station_master')->where('id', 1)->exists()) {
                // 局数のマスターデータ
                DB::table('station_master')->insert([
                    ['station' => '東1局'],
                    ['station' => '東2局'],
                    ['station' => '東3局'],
                    ['station' => '東4局'],
                    ['station' => '南1局'],
                    ['station' => '南2局'],
                ]);
            }

            if (!DB::table('direction_master')->where('id', 1)->exists()) {
                // 自風のマスターデータ
                DB::table('direction_master')->insert([
                    ['direction' => '東家'],
                    ['direction' => '南家'],
                    ['direction' => '西家'],
                    ['direction' => '北家'],
                ]);
            }

            if (!DB::table('tiles_group_master')->where('id', 1)->exists()) {
                // 牌グループのマスターデータ
                DB::table('tiles_group_master')->insert([
                    ['tiles_group_name' => '萬子'],
                    ['tiles_group_name' => '筒子'],
                    ['tiles_group_name' => '索子'],
                    ['tiles_group_name' => '字牌'],
                ]);
            }

            if (!DB::table('mahjong_tiles_master')->where('id', 1)->exists()) {
                // 雀牌画像のマスターデータ
                DB::table('mahjong_tiles_master')->insert([
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '一萬',
                        'mahjong_tiles' => '/storage/man1-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '二萬',
                        'mahjong_tiles' => '/storage/man2-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '三萬',
                        'mahjong_tiles' => '/storage/man3-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '四萬',
                        'mahjong_tiles' => '/storage/man4-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '五萬',
                        'mahjong_tiles' => '/storage/man5-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '五萬(赤)',
                        'mahjong_tiles' => '/storage/aka3-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '六萬',
                        'mahjong_tiles' => '/storage/man6-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '七萬',
                        'mahjong_tiles' => '/storage/man7-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '八萬',
                        'mahjong_tiles' => '/storage/man8-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 1,
                        'tiles_name' => '九萬',
                        'mahjong_tiles' => '/storage/man9-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '一筒',
                        'mahjong_tiles' => '/storage/pin1-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '二筒',
                        'mahjong_tiles' => '/storage/pin2-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '三筒',
                        'mahjong_tiles' => '/storage/pin3-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '四筒',
                        'mahjong_tiles' => '/storage/pin4-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '五筒',
                        'mahjong_tiles' => '/storage/pin5-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '五筒(赤)',
                        'mahjong_tiles' => '/storage/aka1-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '六筒',
                        'mahjong_tiles' => '/storage/pin6-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '七筒',
                        'mahjong_tiles' => '/storage/pin7-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '八筒',
                        'mahjong_tiles' => '/storage/pin8-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 2,
                        'tiles_name' => '九筒',
                        'mahjong_tiles' => '/storage/pin9-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '一索',
                        'mahjong_tiles' => '/storage/sou1-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '二索',
                        'mahjong_tiles' => '/storage/sou2-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '三索',
                        'mahjong_tiles' => '/storage/sou3-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '四索',
                        'mahjong_tiles' => '/storage/sou4-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '五索',
                        'mahjong_tiles' => '/storage/sou5-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '五索(赤)',
                        'mahjong_tiles' => '/storage/aka2-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '六索',
                        'mahjong_tiles' => '/storage/sou6-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '七索',
                        'mahjong_tiles' => '/storage/sou7-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '八索',
                        'mahjong_tiles' => '/storage/sou8-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 3,
                        'tiles_name' => '九索',
                        'mahjong_tiles' => '/storage/sou9-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '東',
                        'mahjong_tiles' => '/storage/ji1-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '南',
                        'mahjong_tiles' => '/storage/ji2-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '西',
                        'mahjong_tiles' => '/storage/ji3-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '北',
                        'mahjong_tiles' => '/storage/ji4-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '白',
                        'mahjong_tiles' => '/storage/ji5-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '發',
                        'mahjong_tiles' => '/storage/ji6-66-90-l-emb.png'
                    ],
                    [
                        'tiles_group_id' => 4,
                        'tiles_name' => '中',
                        'mahjong_tiles' => '/storage/ji7-66-90-l-emb.png'
                    ],
                ]);
            }

            if (!DB::table('mahjong_problem')->where('id', 1)->exists()) {
                // 麻雀問題
                DB::table('mahjong_problem')->insert([
                    [
                        'problem_tiles1' => '2',
                        'problem_tiles2' => '3',
                        'problem_tiles3' => '8',
                        'problem_tiles4' => '9',
                        'problem_tiles5' => '16',
                        'problem_tiles6' => '17',
                        'problem_tiles7' => '22',
                        'problem_tiles8' => '23',
                        'problem_tiles9' => '24',
                        'problem_tiles10' => '24',
                        'problem_tiles11' => '25',
                        'problem_tiles12' => '36',
                        'problem_tiles13' => '36',
                        'problem_description' => '何をきるでしょう？',
                        'station_id' => 1,
                        'direction_id' => 2,
                        'round' => 4,
                        'dora' => 1,
                        'have_point' => 25000,
                        'answer1' => 2,
                        'answer2' => 5,
                        'description' => '2萬と3萬か、4索と5索のどちらかで迷うと思うが、頭がない時は連続した牌が強いので、2萬か3萬のどちらかを切るのが正解です.',
                        'publish' => true,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ]
                ]);
            }

            if (!DB::table('user_answer')->where('id', 1)->exists()) {
                // 回答
                DB::table('user_answer')->insert([
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 3,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 3,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 2,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 3,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 3,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 2,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 2,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 2,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 2,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                    [
                        'mahjong_problem_id' => 1,
                        'select_tile' => 17,
                        'created_at' => new Carbon('now'),
                        'updated_at' => new Carbon('now'),
                    ],
                ]);
            }
        });
    }
}

