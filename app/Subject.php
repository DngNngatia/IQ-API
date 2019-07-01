<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{
    protected $fillable = ['topic_id', 'subject_name', 'subject_avatar_url'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }
    public function score(){
        return $this->hasMany(Score::class);
    }
}
