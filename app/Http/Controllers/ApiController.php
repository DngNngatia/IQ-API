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
        $topics = Topic::paginate(3);
        return response()->json(["data" => $topics], 200);
    }

    public function subjects(Request $request, $id)
    {
        $subjects = Subject::where('topic_id', $id)->get();
        $results = collect($subjects)->map(function ($subject) use($request){
            return [
                'id' => $subject->id,
                'topic_id' => $subject->topic_id,
                'subject_name' => $subject->subject_name,
                'subject_avatar_url' => $subject->subject_avatar_url,
                'score' => Score::where('user_id',$request->user()->id)->where('subject_id',$subject->id)->first()
            ];
        })->forPage(1, 3);
        return response()->json(["data" => $results], 200);
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
        $user = User::findOrFail($request->user()->id);
        $user->update([
            'name' => $request->input("name"),
            'address' => $request->input("address"),
            'phone' => $request->input("phone"),
            'title' => $request->input("title"),
            'description' => $request->input("description")
        ]);
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('avatars');
            $user->update([
                'profile_image' => $path
            ]);
        }
        return response()->json(["message" => "success", "data" => $user]);
    }

    public function attempted(Request $request)
    {
        $scores = collect($request->user()->score)->map(function ($score) {
            return [
                'score' => $score->score,
                'subject' => $score->subject
            ];
        });
        return response()->json(["message" => "success", "data" => $scores]);
    }
}
