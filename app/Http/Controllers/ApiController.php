<?php

namespace App\Http\Controllers;

use App\Question;
use App\Score;
use App\Subject;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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
        $results = collect($subjects)->map(function ($subject) use ($request) {
            return [
                'id' => $subject->id,
                'topic_id' => $subject->topic_id,
                'subject_name' => $subject->subject_name,
                'subject_avatar_url' => $subject->subject_avatar_url,
                'created_at' => $subject->created_at,
                'score' => Score::where('user_id', $request->user()->id)->where('subject_id', $subject->id)->first()
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

    public function search($query)
    {
        $topic = Topic::paginate(3);
        if ($query != "") {
            $count = count(Topic::where('topic_name', 'LIKE', '%' . $query . '%')->orWhere('description', 'LIKE', '%' . $query . '%')->get());
            $topics = Topic::where('topic_name', 'LIKE', '%' . $query . '%')->orWhere('description', 'LIKE', '%' . $query . '%')->paginate(3)->setPath('');
            $pagination = $topics->appends(array(
                'query' => $query
            ));
            if (count($topics) > 0) {
                return response()->json(["data" => $pagination, "message" => $count . " items found!"], 200);
            } else {
                return response()->json(["data" => $topic, "message" => "No results found"], 200);
            }

        }
        return response()->json(["message" => "Search query is empty!!", "data" => $topic], 200);
    }

    public function available(Request $request)
    {
        $subjects = collect(Subject::get())->filter(function ($subject) use ($request) {
            return count(
                    collect($subject->score)->filter(function ($score) use ($request) {
                        return $score->user_id !== $request->user()->id;
                    })
                ) < 1;
        });
        return response()->json(["message" => "available", "data" => $subjects], 200);
    }

    public function updateProfile(Request $request)
    {
        $request->user()->update([
            'name' => $request->input("name"),
            'address' => $request->input("address"),
            'phone' => $request->input("phone"),
            'title' => $request->input("title"),
            'description' => $request->input("description")
        ]);
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('avatars');
            $request->user()->update([
                'profile_image' => $path
            ]);
        }
        return response()->json(["message" => "success", "data" => $request->user()]);
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
