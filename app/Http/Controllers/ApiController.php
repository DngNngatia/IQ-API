<?php

namespace App\Http\Controllers;

use App\Question;
use App\Score;
use App\Subject;
use App\Topic;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function topics()
    {
        $topics = Topic::get();
        return response()->json(["data" => $topics],200);
    }

    public function subjects($id)
    {
        $subjects = Subject::where('topic_id', $id)->get();
        return response()->json(["data" => $subjects],200);
    }

    public function questions($id)
    {
        $questions = Question::where('subject_id', $id)->with('answer')->get();
        return response()->json(["data" => $questions],200);
    }

    public function scores($user_id, $subject_id)
    {
        $score = Score::where('user_id', $user_id)->where('subject_id', $subject_id)->with('user')->first();
        return response()->json(["data" => $score],200);
    }
}
