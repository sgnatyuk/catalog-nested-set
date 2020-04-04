<?php

namespace App\Actions\Product;

use App\Actions\Result;
use App\DTO\Product\UploadImageDTO;
use App\Proxies\ImageProxy;
use Ramsey\Uuid\Uuid;

class UploadImageAction
{
    private ImageProxy $imageProxy;

    public function __construct(ImageProxy $imageProxy)
    {
        $this->imageProxy = $imageProxy;
    }

    public function execute(UploadImageDTO $uploadImageDTO): Result
    {
        try {

            $file = $uploadImageDTO->image;

            $fileName = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('images', $fileName, 'public');

            $image = $this->imageProxy->create($fileName);

            return Result::success([
                'id'   => $image->id,
                'name' => $fileName,
            ]);

        } catch (\Throwable $e) {
            return Result::error($e);
        }
    }
}
