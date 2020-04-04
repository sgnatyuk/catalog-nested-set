<?php

namespace App\Proxies;

use App\Models\Category;
use App\Proxies\Abstracts\EloquentProxy;
use Illuminate\Support\Str;

class CategoryProxy extends EloquentProxy
{
    public function create(string $title, string $content): Category
    {
        $slug = Str::slug($title);

        $duplicate = Category::query()->where('slug', $slug)->first();

        if ($duplicate) {
            throw new \DomainException('Slug already exists');
        }

        return Category::create([
            'slug'    => $slug,
            'title'   => $title,
            'content' => $content,
        ]);
    }

    public function edit(Category $category, ?int $parentId, string $title, string $content): bool
    {
        $slug = Str::slug($title);

        $duplicate = Category::query()
            ->where('slug', $slug)
            ->where('id', '<>', $category->id)
            ->first();

        if ($duplicate) {
            throw new \DomainException('Slug already exists');
        }

        return $category
            ->fill([
                'parent_id' => $parentId,
                'slug'      => $slug,
                'title'     => $title,
                'content'   => $content,
            ])
            ->save();
    }

    public function delete(Category $category): ?bool
    {
        return $category->delete();
    }
}
