<?php

namespace App\Http\Controllers;

use App\Score;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{

    public function store(Request $request, $subject_id)
    {
        $score = Score::create([
            'user_id' => $request->user()->id,
            'subject_id' => $subject_id,
            'complete' => true,
            'score' => $request->input("score")
        ]);

        return response()->json(["message" => 'success', "data" => $score]);

    }

    public function subjects()
    {
        $scores = collect(User::findOrFail(Auth::id())->score)->each(function ($score) {
            return $score->subject;
        })->toArray();
        return response()->json(["message" => 'success', "data" => $scores]);
    }
}
