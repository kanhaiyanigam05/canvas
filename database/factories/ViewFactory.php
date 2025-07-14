<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Kanhaiyanigam05\Models\View::class, function (Faker\Generator $faker) {
    return [
        'post_id' => $faker->uuid,
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'referer' => $faker->url,
    ];
});
