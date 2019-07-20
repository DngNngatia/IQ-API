<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Score;
use App\Subject;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $subject_id){
        $comment= new Comment([
            'user_id' =>$request->user()->id,
            'subject_id' => $subject_id,
            'comment' => $request->comment,
        ]);
        Subject::findOrFail($subject_id)->comments()->save($comment);
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
                'comments' => $subject->comments->map(function ($comment) {
                    return [
                        'subject_id' => $comment->subject_id,
                        'comment' => $comment->comment,
                        'commentable_type' => $comment->comment,
                        'user' => $comment->user
                    ];
                }),
                'score' => Score::where('user_id', $request->user()->id)->where('subject_id', $subject->id)->first()
            ];
        })->forPage(1, 3);
        return response()->json(["data" => $results], 200);
    }
}
