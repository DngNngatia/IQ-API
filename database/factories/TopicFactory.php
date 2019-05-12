<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$urls=["http://www.freelogovectors.net/photo6/laravel-logo.jpg","https://ih0.redbubble.net/image.393347411.1344/flat,550x550,075,f.jpg","https://www.pngkit.com/png/detail/373-3738691_react-native-svg-transformer-allows-you-import-svg.png"];

$factory->define(\App\Topic::class, function (Faker $faker) use ($urls) {
    return [
        'topic_name' => $faker->sentence,
        'topic_avatar_url'=>$faker->randomElement($urls)
    ];
});
