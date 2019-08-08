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
    Route::get('/user/completed','ApiController@attempted');
    Route::get('/search/topic/{query}','ApiController@search');
    Route::get('/topics/available','ApiController@available');
    Route::get('/like/{subject_id}','LikeController@like');
    Route::get('/dislike/{subject_id}','DislikeController@dislike');
    Route::post('/comment/{subject_id}','CommentController@store');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/profile/delete','ApiController@deleteProfile');
    Route::post('/logout', function (Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    });
    Route::post('/user/update','ApiController@updateProfile');
});

Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@signup');
Route::post('/reset/password','LoginController@email');
Route::post('/otp','LoginController@resetPassword');



