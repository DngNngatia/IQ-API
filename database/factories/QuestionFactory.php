<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Question::class, function (Faker $faker,$subject_id) {
    return [
        'subject_id' =>$subject_id,
        'question' => $faker->paragraph,
        'time_allocated' => $faker->time('H:i:s',now()->addMinutes(20))
    ];
});
