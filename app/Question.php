<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['subject_id', 'question', 'time_allocated'];

    protected static function boot()
    {
        static::deleting(function ($question) {
            collect($question->answer)->each(function ($answer) {
                $answer->delete();
            });
        });
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
}
