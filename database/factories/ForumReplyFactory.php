<?php

/** @var Factory $factory */

use App\Models\Forum\ForumCategory;
use App\Models\Forum\ForumReply;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ForumReply::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'forum_question_id' => function(){
            return ForumCategory::all()->random();
        },
        'user_id' => function(){
            return User::all()->random();
        },
    ];
});
