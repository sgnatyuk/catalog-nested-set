<?php

namespace App\DTO\Category;

use App\Models\Category;

final class EditDTO
{
    public Category $category;

    public ?int $parentId;
    public string $title;
    public string $content;

    public function __construct(Category $category, ?int $parentId, string $title, string $content)
    {
        $this->category = $category;

        $this->parentId = $parentId;
        $this->title = $title;
        $this->content = $content;
    }
}
