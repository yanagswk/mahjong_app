<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahjongProblemRequest extends FormRequest
{
    private $tiles_length;      // 手牌数
    private $round;             // 最大巡目

    public function __construct()
    {
        $this->tiles_length = config('mahjong_problem.tiles_length');
        $this->round = config('mahjong_problem.round');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tiles_id_list' => "required|array|size:{$this->tiles_length}",
            'tiles_id_list.*' => 'required|integer',
            'user_id' => 'required|integer',
            'station' => 'nullable|integer',
            'direction' => 'nullable|integer',
            'dora_tiles' => 'nullable|integer',
            'round' => "nullable|integer|max:{$this->round}",
            'have_point' => 'nullable|integer',
            'answer_tiles' => 'required|integer',
            'commentary' => 'nullable|string'
        ];
    }
}
