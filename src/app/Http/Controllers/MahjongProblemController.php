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
            ->get();

        // 空の場合
        if (empty($problem_list)) {
            return response()->json([
                // 'error_code' => '1000',
                'message' => 'mahjong problem not found'
            ], 404);
        }

        return response()->json([
            'problem_list' => $problem_list
        ], 200);
    }
}