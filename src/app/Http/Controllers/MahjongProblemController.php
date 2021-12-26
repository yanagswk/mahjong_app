<?php

namespace App\Http\Controllers;

use App\DirectionMaster;
use App\Http\Requests\MahjongProblemRequest;
use Illuminate\Http\Request;
use App\MahjongProblem;
use App\MahjongTilesMaster;
use App\Module\MahjongProblemModule;
use App\StationMaster;
use App\TilesGroupMaster;
use App\UserAnswer;
use Illuminate\Support\Facades\Auth;
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

        if (empty($user_answer_list)) {
            $user_answer_list = [];
        }

        $mahjong_problem = MahjongProblem::where('mahjong_problem.id', $question_id)
            ->problemList()
            ->first()
            ->toArray();

        \Log::debug($mahjong_problem);

        $mahjong_problem_module = new MahjongProblemModule();

        // TODO: ランキングのキーを追加する前に、一応並び順をチェックしとく
        $user_answer_rank_list = $mahjong_problem_module->setAnswerRanking($user_answer_list);

        // 回答数を求める
        $answer_count = $mahjong_problem_module->sumAnswerCount($user_answer_rank_list);

        // TODO: ここの処理変えたい problem_tilesなどは中間カラム持たせる？
        $problem = $mahjong_problem_module->hierarchyDown($mahjong_problem);

        // \Log::debug($mahjong_problem);
        // \Log::debug($problem);

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
    public function getPostQuestion()
    {
        // 全ての牌を取得
        $mahjong_tiles_master = MahjongTilesMaster::select()
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        if (empty($mahjong_tiles_master)) {
            $mahjong_tiles_master = [];
        }

        // 局マスターデータ取得
        $station_list = StationMaster::select()
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        // 自風マスターデータ取得
        $direction_list = DirectionMaster::select()
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        $tiles_group_list = TilesGroupMaster::select()
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        // 巡目データ返す(20ぐらいまで)
        $round = (config('mahjong_problem.round')) ? config('mahjong_problem.round') : 20;

        // 全牌の名前を返す
        // $mahjong_problem = new MahjongProblemModule;
        // $tiles_name_list = $mahjong_problem->getTilesNameArray($mahjong_tiles_master);

        // TODO: tiles_group_masterテーブルも返してあげて、vue側で処理する

        return response()->json([
            'station_list' => $station_list,
            'direction_list' => $direction_list,
            'tiles_name_list' => $mahjong_tiles_master,
            'tiles_group_list' => $tiles_group_list,
            'round' => $round
        ]);
    }

    /**
     * 問題投稿処理
     */
    public function postQuestion(MahjongProblemRequest $request)
    {
        $only_request = $request->only([
            'tiles_id_list',
            'user_id',
            'station',
            'direction',
            'answer_tiles',
            'dora_tiles',
            'round',
            'have_point',
            'commentary'
        ]);

        \Log::debug($only_request);

        $user_id = $request->input('user_id');

        if (Auth::id() !== $user_id) {
            return false;
        }

        // 各パラメーターがマスターデータに存在するか

        DB::transaction(function () use($only_request) {
            $data = [
                'user_id' => $only_request['user_id'],
                'problem_tiles1' => $only_request['tiles_id_list'][0],
                'problem_tiles2' => $only_request['tiles_id_list'][1],
                'problem_tiles3' => $only_request['tiles_id_list'][2],
                'problem_tiles4' => $only_request['tiles_id_list'][3],
                'problem_tiles5' => $only_request['tiles_id_list'][4],
                'problem_tiles6' => $only_request['tiles_id_list'][5],
                'problem_tiles7' => $only_request['tiles_id_list'][6],
                'problem_tiles8' => $only_request['tiles_id_list'][7],
                'problem_tiles9' => $only_request['tiles_id_list'][8],
                'problem_tiles10' => $only_request['tiles_id_list'][9],
                'problem_tiles11' => $only_request['tiles_id_list'][10],
                'problem_tiles12' => $only_request['tiles_id_list'][11],
                'problem_tiles13' => $only_request['tiles_id_list'][12],
                'problem_description' => $only_request['problem_description'] ?? null,
                'station_id' => $only_request['station'],
                'direction_id' => $only_request['direction'],
                'round' => $only_request['round'],
                'dora' => $only_request['dora_tiles'],
                'have_point' => $only_request['have_point'],
                'answer1' => $only_request['answer_tiles'],
                'answer2' => null,
                'description' => $only_request['commentary'],
                'publish' => true,
            ];

            \Log::debug($data);

            $mahjong_problem = new MahjongProblem;
            $mahjong_problem->fill($data)->save();
        });




    }
}
