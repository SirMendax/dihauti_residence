<?php

/** @var Factory $factory */

use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumQuestion;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ForumQuestion::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->title,
        'body' => $faker->text,
        'forum_category_id' => function(){
            return ForumCategory::all()->random();
        },
        'user_id' => function(){
            return User::all()->random();
        },
    ];
});
