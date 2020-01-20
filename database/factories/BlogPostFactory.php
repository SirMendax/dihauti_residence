<?php

/** @var Factory $factory */

use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Models\Blog\BlogPost::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->title,
        'description' => $faker->text(255),
        'body' => $faker->text,
        'published_at' => $faker->dateTimeThisMonth,
        'blog_category_id' => function(){
            return BlogCategory::all()->random();
        },
        'user_id'   => function(){
            return User::where('name', 'Mendax')->first()->get();
        },
    ];
});
