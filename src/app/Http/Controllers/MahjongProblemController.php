<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MahjongProblem;

class MahjongProblemController extends Controller
{
    /**
     * 問題取得
     */
    public function getProblemList()
    {
        // 問題取得
        $problem_list = MahjongProblem::ProblemList()
            ->Active()
            ->get()
            ->toArray();

        // 空の場合
        if (empty($problem_list)) {
            return response()->json([
                // 'error_code' => '1000',
                'message' => 'mahjong problem not found'
            ], 404);
        }

        // TODO: ここの処理変えたい problem_tilesなどは中間カラム持たせる？
        foreach ($problem_list as $key => $problem) {
            foreach ($problem as $key2 => $problem2) {
                // TODO: 仮データ 消す予定
                if ($key2 == 'user_id') {
                    $problem_list[$key][$key2] = 111111;
                }

                if (strpos($key2, 'problem_tiles') !== false) {
                    $problem_tiles_list[] = $problem_list[$key][$key2];
                    unset($problem_list[$key][$key2]);
                }

                if (strpos($key2, 'answer') !== false) {
                    $answer_list[] = $problem_list[$key][$key2];
                    unset($problem_list[$key][$key2]);
                }
            }
            $problem_list[$key]['problem_tiles'] = $problem_tiles_list;
            $problem_list[$key]['answer'] = $answer_list;
            unset($problem_tiles_list);
            unset($answer_list);
        }

        return response()->json([
            'problem_list' => $problem_list,
        ], 200);
    }
}
