<?php

namespace App\Proxies;

use App\Models\Product;
use App\Proxies\Abstracts\EloquentProxy;
use Illuminate\Support\Str;

class ProductProxy extends EloquentProxy
{
    public function create(string $title, string $content): Product
    {
        $slug = Str::slug($title);

        $duplicate = Product::query()->where('slug', $slug)->first();

        if ($duplicate) {
            throw new \DomainException('Slug already exists');
        }

        return Product::create([
            'slug'    => $slug,
            'title'   => $title,
            'content' => $content,
        ]);
    }

    public function edit(Product $product, ?int $categoryId, ?int $imageId, string $title, string $content): bool
    {
        $slug = Str::slug($title);

        $duplicate = Product::query()
            ->where('slug', $slug)
            ->where('id', '<>', $product->id)
            ->first();

        if ($duplicate) {
            throw new \DomainException('Slug already exists');
        }

        return $product
            ->fill([
                'category_id' => $categoryId,
                'image_id'    => $imageId,
                'slug'        => $slug,
                'title'       => $title,
                'content'     => $content,
            ])
            ->save();
    }

    public function delete(Product $product): ?bool
    {
        return $product->delete();
    }
}
