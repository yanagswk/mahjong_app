<?php

namespace App\Module;


class MahjongProblemModule
{
    /**
     * 指定したkeyの階層を下げる
     *
     * @param array $problem_list 問題の配列
     */
    public function hierarchyDown(array $problem_list): array
    {
        foreach ($problem_list as $key => $problem) {

            // TODO: 仮データ 消す予定
            if ($key == 'user_id') {
                $problem_list[$key] = 111111;
            }

            if (strpos($key, 'problem_tiles') !== false) {
                $problem_tiles_list[] = $problem_list[$key];
                unset($problem_list[$key]);
            }

            if (strpos($key, 'answer') !== false) {
                $answer_list[] = $problem_list[$key];
                unset($problem_list[$key]);
            }
        }
        $problem_list['problem_tiles'] = $problem_tiles_list;
        $problem_list['answer'] = $answer_list;

        return $problem_list;
    }


    /**
     * ユーザーの回答の牌が問題に含まれてるか
     *
     * @param array $problem_tiles_list     問題が格納された配列
     * @param array $user_answer_rate       回答の割合が格納された配列
     * @return boolean  true:含まれてる / false:含まれていない
     */
    public function chkAnswerTileInProblem(array $problem_tiles_list, array $user_answer_rate): bool
    {
        $mahjong_tiles_list = array_column($user_answer_rate, 'mahjong_tiles');
        foreach ($mahjong_tiles_list as $mahjong_tiles) {
            if (!in_array($mahjong_tiles, $problem_tiles_list)) {
                return false;
            }
        }
        return true;
    }
}

?>
