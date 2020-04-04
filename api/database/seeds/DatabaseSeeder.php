<?php

use Illuminate\Database\Seeder;

use App\Models\{
    Category,
    Product
};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 4)
            ->create()
            ->each(function (Category $category) {

                $category->children()->saveMany(
                    factory(Category::class, random_int(1, 3))
                        ->create()
                        ->each(function (Category $category) {

                            $category->children()->saveMany(
                                factory(Category::class, random_int(1, 3))->make()
                            );
                        })
                );
            });

        factory(Product::class, 400)->create();
    }
}
