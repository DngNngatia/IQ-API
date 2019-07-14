<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    protected $fillable = ['topic_id', 'subject_name', 'subject_avatar_url'];

    protected static function boot()
    {
        static::deleting(function ($subject) {
            collect($subject->question)->each(function ($question) {
                collect($question->answer)->each(function ($answer){
                    $answer->delete();
                });
                $question->delete();
            });
            $subject->delete();
        });
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    public function score()
    {
        return $this->hasMany(Score::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class)->count();
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class)->count();
    }
}
