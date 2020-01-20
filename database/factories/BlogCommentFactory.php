<?php

/** @var Factory $factory */

use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Date;

$factory->define(BlogComment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'blog_post_id' => function(){
            return BlogPost::all()->random();
        },
        'user_id' => function(){
            return User::all()->random();
        },
    ];
});
