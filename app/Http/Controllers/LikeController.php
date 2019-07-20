<?php

namespace App\Http\Controllers;

use App\Dislike;
use App\Like;
use App\Score;
use App\Subject;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request,$subject_id){
        if(Dislike::where('user_id',$request->user()->id)->where('subject_id',$subject_id)->exists()){
            Dislike::where('user_id',$request->user()->id)->where('subject_id',$subject_id)->delete();
        }
        Like::updateOrCreate([
            'user_id' => $request->user()->id,
            'subject_id' => $subject_id,
            'liked' => true
        ]);
        $subjects = Subject::where('topic_id',Subject::where('id',$subject_id)->first()->topic_id)->get();
        $results = collect($subjects)->map(function ($subject) use ($request) {
            return [
                'id' => $subject->id,
                'topic_id' => $subject->topic_id,
                'subject_name' => $subject->subject_name,
                'subject_avatar_url' => $subject->subject_avatar_url,
                'created_at' => $subject->created_at,
                'likes' => count($subject->likes),
                'dislikes' => count($subject->dislikes),
                'no_comments' => count($subject->comments),
                'comments' => $subject->comments,
                'score' => Score::where('user_id', $request->user()->id)->where('subject_id', $subject->id)->first()
            ];
        })->forPage(1, 3);
        return response()->json(["data" => $results], 200);
    }
}
