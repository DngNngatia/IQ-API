<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['topic_name', 'topic_avatar_url'];

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }
}
