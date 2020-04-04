<?php

namespace App\Actions\Category;

use App\Actions\Result;
use App\DTO\Category\EditDTO;
use App\Proxies\CategoryProxy;

class EditAction
{
    private CategoryProxy $categoryProxy;

    public function __construct(CategoryProxy $categoryProxy)
    {
        $this->categoryProxy = $categoryProxy;
    }

    public function execute(EditDTO $editDTO): Result
    {
        try {

            $this->categoryProxy->edit(
                $editDTO->category,
                $editDTO->parentId,
                $editDTO->title,
                $editDTO->content
            );

            return Result::success();

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
