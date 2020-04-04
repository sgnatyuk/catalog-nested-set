<?php

namespace App\Actions\Category;

use App\Actions\Result;
use App\DTO\Category\CreateDTO;
use App\Proxies\CategoryProxy;

class CreateAction
{
    private CategoryProxy $categoryProxy;

    public function __construct(CategoryProxy $categoryProxy)
    {
        $this->categoryProxy = $categoryProxy;
    }

    public function execute(CreateDTO $createDTO): Result
    {
        try {

            $category = $this->categoryProxy->create(
                $createDTO->title,
                $createDTO->content
            );

            return Result::success([
                'categoryId' => $category->id,
            ]);

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
