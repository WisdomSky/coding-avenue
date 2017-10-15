<?php
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker, $author) {

    $title = $faker->text(100);

    return [
        'title' => $title,
        'slug' => str_slug($title, '-'),
        'content' => $faker->paragraphs(10, true),
        'type' => 'published'
    ];
});