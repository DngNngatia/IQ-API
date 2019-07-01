<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
