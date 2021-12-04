<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// 問題一覧取得api
Route::get('problem_list', 'MahjongProblemController@getProblemList');

// 回答送信api
Route::post('post_answer', 'MahjongProblemController@setProblemAnswer');

// 回答取得api
Route::get('answer_result', 'MahjongProblemController@getAnswerResult');
