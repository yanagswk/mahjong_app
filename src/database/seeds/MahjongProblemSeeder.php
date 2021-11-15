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
        DB::table('station_master')->insert([
            ['station' => '東1局'],
            ['station' => '東2局'],
            ['station' => '東3局'],
            ['station' => '東4局'],
            ['station' => '南1局'],
            ['station' => '南2局'],
        ]);

        DB::table('direction_master')->insert([
            ['direction' => '東家'],
            ['direction' => '南家'],
            ['direction' => '西家'],
            ['direction' => '北家'],
        ]);

        // DB::table('mahjong_tiles_master')->insert([
        // ]);
    }
}

