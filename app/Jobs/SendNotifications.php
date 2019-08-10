<?php

namespace App\Jobs;

use App\Notifications\SendUserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $users,$subject,$message;

    /**
     * SendNotifications constructor.
     * @param $users
     * @param $subject
     * @param $message
     */
    public function __construct($users, $subject, $message)
    {
        $this->users = $users;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->users)->each(function ($user){
            $user['message'] = $this->message.$this->subject->name;
           $user->notify(new SendUserNotification()) ;
        });
    }
}
