<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Friendship;
use Faker\Generator as Faker;

$factory->define(Friendship::class, function (Faker $faker) {
    return [
        'recipient_id' => function(){
            return factory(\App\User::class)->create();
        },
        'sender_id' => function(){
            return factory(\App\User::class)->create();
        }
    ];
});
