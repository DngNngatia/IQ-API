<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    protected $fillable = ['topic_id', 'attempts', 'subject_name', 'subject_avatar_url'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    public function score(){
        return $this->belongsTo(Score::class)->where('user_id',Auth::id())->where('subject_id',$this->topic_id)->first();
    }
}
