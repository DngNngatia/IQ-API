<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Subject::class, function (Faker $faker,$topic_id) {
    return [
        'topic_id'=>$topic_id,
        'subject_name' => $faker->sentence,
        'subject_avatar_url' => $faker->imageUrl(150,150,null,true,true)
    ];
});
