<?php

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Category::class, function (Faker $faker) {

    $title = $faker->unique()->name;
    $slug = Str::slug($title);

    return [
        'parent_id' => 0,
        'slug'      => $slug,
        'title'     => $title,
        'content'   => $faker->text,
    ];
});
