<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        //
        'content'=>$faker->text(100),
        'user_id'=>$faker->randomElement([1,2,3])
    ];
});
