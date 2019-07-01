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
        $score = Score::createOrUpdate([
            'user_id' => $request->user()->id,
            'subject_id' => $subject_id,
            'complete' => true,
            'score' => $request->input("score")
        ]);

        return response()->json(["message" => 'success', "data" => $score]);

    }
}
