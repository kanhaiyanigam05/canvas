<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\kanhaiyanigam05\Models\Visit::class, function (Faker\Generator $faker) {
    return [
        'post_id' => $faker->uuid,
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'referer' => $faker->url,
    ];
});
