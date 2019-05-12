<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
$factory->define(\App\Answer::class, function (Faker $faker, $question_id)  {
    return [
        'question_id' => $question_id,
        'answer' => $faker->sentence,
        'correct' => count(\App\Question::where('id',$question_id)->get()) ==3  ? true : false
    ];
});
