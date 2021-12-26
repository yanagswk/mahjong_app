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


    /**
     * ランキングのキーを追加する
     *
     * @param array $answer_list
     */
    public function setAnswerRanking(array $answer_list): array
    {
        if (empty($answer_list)) {
            return [];
        }
        foreach ($answer_list as $index => $answer) {
            $answer_list[$index] = array_merge($answer_list[$index], ['ranking' => $index + 1]);
        }
        return $answer_list;
    }


    /**
     * ユーザの回答数を求める
     *
     * @param array $answer_list 回答リスト
     * @param int 回答数
     */
    public function sumAnswerCount(array $answer_list): int
    {
        if (empty($answer_list)) {
            return 0;
        }
        $answer_count = array_column($answer_list, 'answer_count');
        $answer_sum = array_sum($answer_count);
        return $answer_sum;
    }


    /**
     * 牌の名前のみの配列を返す
     * @param array $mahjong_tiles_master 牌のマスターデータ
     * @return array
     */
    public function getTilesNameArray(array $mahjong_tiles_master): array
    {
        if (empty($mahjong_tiles_master)) {
            return [];
        }
        $tiles_name_list = array_column($mahjong_tiles_master, 'tiles_name');
        return $tiles_name_list;
    }
}

?>
