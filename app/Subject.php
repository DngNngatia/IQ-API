<?php

namespace App;

use App\Jobs\SendNotifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Subject extends Model
{

    protected $fillable = ['topic_id', 'subject_name', 'subject_avatar_url'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subject) {
            $users = User::where('notify_me',true)->get();
            dispatch_now(new SendNotifications($users,$subject,'New Subject available, '));
        });

        static::updating(function ($subject) {
            $users = User::where('notify_me',true)->get();
            dispatch_now(new SendNotifications($users,$subject,'New questions added to subject, '));
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
        return $this->hasMany(Like::class);
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }
}
