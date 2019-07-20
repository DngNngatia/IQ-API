<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['subject_id', 'question', 'time_allocated'];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
}
