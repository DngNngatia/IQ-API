<?php

namespace App\Http\Controllers;

use App\Score;
use App\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{

    public function store(Request $request, $user_id, $subject_id)
    {
        $score = Score::updateOrCreate([
            'user_id' => $user_id,
            'subject_id' => $subject_id,
            'complete' => true,
        ], [
            'score' => $request->input("score")
        ]);

        return response()->json(["message" => 'success', "data" => $score]);

    }

    public function subjects($user_id)
    {
        $scores = collect(User::findOrFail($user_id)->score)->each(function ($score) {
            return $score->subject;
        })->toArray();
        return response()->json(["message" => 'success', "data" => $scores]);
    }
}
