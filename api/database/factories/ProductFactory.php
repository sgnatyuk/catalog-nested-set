<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

use App\Models\{
    Category,
    Product
};

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Product::class, function (Faker $faker) {

    $title = $faker->unique()->name;
    $slug = Str::slug($title);

    $min = 0;
    $max = 0;

    if (!($min && $max)) {
        $min = Category::query()->min('id');
        $max = Category::query()->max('id');
    }

    return [
        'category_id' => random_int($min, $max),
        'slug'        => $slug,
        'title'       => $title,
        'content'     => $faker->text,
    ];
});
