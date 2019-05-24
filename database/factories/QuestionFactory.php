<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Question::class, function (Faker $faker,$subject_id) {
    return [
        'subject_id' =>$subject_id,
        'question' => $faker->paragraph,
        'correct_answer' => $faker->randomElement([0,1,2,3]),
        'time_allocated' => $faker->numberBetween(30,200)
    ];
});
