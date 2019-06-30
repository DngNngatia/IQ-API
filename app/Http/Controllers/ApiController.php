<?php

namespace App\Http\Controllers;

use App\Question;
use App\Score;
use App\Subject;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function topics()
    {
        $topics = Topic::get();
        return response()->json(["data" => $topics], 200);
    }

    public function subjects($id)
    {
        $subjects = Subject::where('topic_id', $id)->get();
        return response()->json(["data" => $subjects], 200);
    }

    public function questions($id)
    {
        $questions = Question::where('subject_id', $id)->with('answer')->get();
        return response()->json(["data" => $questions], 200);
    }

    public function scores($user_id, $subject_id)
    {
        $score = Score::where('user_id', $user_id)->where('subject_id', $subject_id)->with('user')->first();
        return response()->json(["data" => $score], 200);
    }

    public function updateProfile(Request $request)
    {
        User::findOrFail($request->user()->id)->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('avatars');
            $request->user()->update([
                'profile_image' => $path
            ]);
        }
        return response()->json(["message" => "success","data" => $request->user()]);
    }
}
