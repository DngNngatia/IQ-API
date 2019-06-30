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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/topics', 'ApiController@topics');
    Route::get('/subjects/{topic_id}', 'ApiController@subjects');
    Route::get('/questions/{subject_id}', 'ApiController@questions');
    Route::get('/answers/{question_id}', 'ApiController@answers');
    Route::get('/scores/{user_id}/subjects/{subject_id}', 'ApiController@scores');
    Route::get('/subjects/score', 'ScoreController@subjects');
    Route::post('/scores/{subject_id}/subjects', 'ScoreController@store');
    Route::post('/logout', function (Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    });
});
Route::post('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@signup');


