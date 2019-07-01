<?php

namespace App\Http\Controllers;

use App\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{

    public function store(Request $request, $subject_id)
    {
        if (Score::where('subject_id',$subject_id)->where('user_id',$request->user()->id)->exists()){
            $score=Score::where('subject_id',$subject_id)->where('user_id',$request->user()->id)->first();
            $score->update([
               'score' => $request->input("score")
            ]);
            $score->subject->update([
                'attempts'  => $score->attempts++
            ]);
        }else{
            $score = Score::create([
                'user_id' => $request->user()->id,
                'subject_id' => $subject_id,
                'complete' => true,
                'score' => $request->input("score")
            ]);
            $score->subject->update([
                'attempts'  => $score->attempts++
            ]);
            return response()->json(["message" => 'success', "data" => $score]);
        }

    }
}
