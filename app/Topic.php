<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['topic_name', 'topic_avatar_url'];

    protected static function boot()
    {
        static::deleting(function ($topic) {
            collect($topic->subject)->each(function ($subject) {
                collect($subject->question)->each(function ($question) {
                    collect($question->answer)->each(function ($answer){
                        $answer->delete();
                    });
                    $question->delete();
                });
                $subject->delete();
            });
        });
    }

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
}
