<?php

namespace App\Actions\Product;

use App\Actions\Result;
use App\DTO\Product\EditDTO;
use App\Proxies\ImageProxy;
use App\Proxies\ProductProxy;

class EditAction
{
    private ProductProxy $productProxy;
    private ImageProxy $imageProxy;

    public function __construct(ProductProxy $productProxy, ImageProxy $imageProxy)
    {
        $this->productProxy = $productProxy;
        $this->imageProxy = $imageProxy;
    }

    public function execute(EditDTO $editDTO): Result
    {
        try {

            $ok = $this->productProxy->edit(
                $editDTO->product,
                $editDTO->categoryId,
                $editDTO->imageId,
                $editDTO->title,
                $editDTO->content
            );

            if ($ok) {
                $this->imageProxy->edit($editDTO->imageId);
            };

            return Result::success();

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
