<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MahjongProblem;
use App\MahjongTilesMaster;
use App\Module\MahjongProblemModule;
use App\UserAnswer;
use Illuminate\Support\Facades\DB;

class MahjongProblemController extends Controller
{
    /**
     * 問題一覧取得
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

        $mahjong_problem = new MahjongProblemModule();

        $hierarchy_down_problem_list = [];
        foreach ($problem_list as $index => $problem) {
            // TODO: ここの処理変えたい problem_tilesなどは中間カラム持たせる？
            $result = $mahjong_problem->hierarchyDown($problem);
            $hierarchy_down_problem_list[] = $result;
        }

        return response()->json([
            'problem_list' => $hierarchy_down_problem_list,
        ], 200);
    }


    /**
     * 問題の回答を登録
     */
    public function setProblemAnswer(Request $request)
    {
        $answer = $request->only(['question_number', 'select_img', 'comment']);

        try {
            $response = DB::transaction(function () use ($answer) {

                $user_answer = new UserAnswer();
                $mahjong_tiles_id = MahjongTilesMaster::select(['id'])
                    ->where('mahjong_tiles', $answer['select_img'])
                    ->first()
                    ->toArray();

                $data = [
                    'mahjong_problem_id' => $answer['question_number'],
                    'select_tile' => $mahjong_tiles_id['id'],
                    'comment' => $answer['comment']
                ];

                $user_answer->fill($data)->save();

                return [
                    'question_number' => $answer['question_number'],
                    'select_img' => $answer['select_img'],
                    'comment' => $answer['comment'],
                ];
            });
        } catch (\Exception $error) {
            return response($error, 404);
        }
        return response($response, 200);
    }


    /**
     * 問題の回答取得
     * @param Request question_id 問題id
     */
    public function getAnswerResult(Request $request)
    {
        $question_id = $request->input('question_id');

        // TODO: answerRateで割合出したけど、phpでやる場合のコードも書いてみる
        $user_answer_list = UserAnswer::answerRate($question_id)
            ->get()
            ->toArray();

        $mahjong_problem = MahjongProblem::where('mahjong_problem.id', $question_id)
            ->problemList()
            ->first()
            ->toArray();

        $mahjong_problem_module = new MahjongProblemModule();

        // TODO: ランキングのキーを追加する前に、一応並び順をチェックしとく
        $user_answer_rank_list = $mahjong_problem_module->setAnswerRanking($user_answer_list);

        // 回答数を求める
        $answer_count = $mahjong_problem_module->sumAnswerCount($user_answer_rank_list);

        // TODO: ここの処理変えたい problem_tilesなどは中間カラム持たせる？
        $problem = $mahjong_problem_module->hierarchyDown($mahjong_problem);

        $result = $mahjong_problem_module->chkAnswerTileInProblem($problem['problem_tiles'], $user_answer_list);

        if (!$result) {
            return response()->json([
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'problem' => $problem,
            'user_answer_list' => $user_answer_rank_list,
            'answer_count' => $answer_count
        ], 200);
    }


    /**
     * 問題投稿画面
     */
    // public function getPostQuestion()
    // {

    // }
}
