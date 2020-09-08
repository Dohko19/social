<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\User;
use Faker\Generator as Faker;
use App\Models\Status;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => function(){
            return factory(User::class)->create();
        },
        'status_id' => function(){
            return factory(Status::class)->create();
        }
    ];
});

