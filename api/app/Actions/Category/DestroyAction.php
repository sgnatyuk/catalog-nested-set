<?php

namespace App\Actions\Category;

use App\Actions\Result;
use App\DTO\Category\DestroyDTO;
use App\Proxies\CategoryProxy;

class DestroyAction
{
    private CategoryProxy $categoryProxy;

    public function __construct(CategoryProxy $categoryProxy)
    {
        $this->categoryProxy = $categoryProxy;
    }

    public function execute(DestroyDTO $destroyDTO): Result
    {
        try {

            $this->categoryProxy->delete($destroyDTO->category);

            return Result::success();

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
