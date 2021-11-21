<?php

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
        // DB::table('station_master')->insert([
        //     ['station' => '東1局'],
        //     ['station' => '東2局'],
        //     ['station' => '東3局'],
        //     ['station' => '東4局'],
        //     ['station' => '南1局'],
        //     ['station' => '南2局'],
        // ]);

        // DB::table('direction_master')->insert([
        //     ['direction' => '東家'],
        //     ['direction' => '南家'],
        //     ['direction' => '西家'],
        //     ['direction' => '北家'],
        // ]);

        // DB::table('mahjong_tiles_master')->insert([
        // ]);

        // 麻雀問題
        DB::table('mahjong_problem')->insert([
            [
                'problem_image_url' => '/Users/yanagisawa/src/myapp/mahjong_app/src/public/image/question01.png',
                'problem_description' => '何をきるでしょう？',
                'station_id' => 1,
                'direction_id' => 2,
                'round' => 4,
                'dora' => 1,
                'have_point' => 25000,
                'answer_select_one' => 2,
                'answer_select_two' => 3,
                'answer_select_three' => 4,
                'answer_select_fore' => 5,
                'answer_one' => 2,
                'answer_two' => 5,
                'answer_description' => '2萬と3萬か、4索と5索のどちらかで迷うと思うが、頭がない時は連続した牌が強いので、2萬か3萬のどちらかを切るのが正解です.',
                'publish' => true
            ]
        ]);
    }
}

