<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Kanhaiyanigam05\Models\Topic::class, function (Faker\Generator $faker) {
    return [
        'id' => $faker->uuid,
        'slug' => $faker->slug,
        'name' => $faker->word,
        'user_id' => function () {
            return factory(\Kanhaiyanigam05\Models\User::class)->create()->id;
        },
    ];
});
